<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseObj = new Course($dbMoObj, MOODLE_DB_PREFIX); // Create an object of Course class
$purchaseRecordObj = new PurchaseRecord($dbObj);
$errorArr = array(); //Array of errors
$iadetEmail = WebsiteContact::getSingle($dbObj, 'email', 1);

include_once __DIR__ . "/vendor/autoload.php"; //include PayPal SDK
include_once __DIR__ . "/functions.inc.php"; //our PayPal functions

$courseQty = 1; 
$courseObj->id = filter_input(INPUT_POST, 'course', FILTER_VALIDATE_INT) ? filter_input(INPUT_POST, 'course', FILTER_VALIDATE_INT): 0;

//
if(isset($_SESSION['IADETuserId'])){
#### Prepare for Payment ####
if($courseObj->id !=0){//isset($_POST['course'])
    foreach ($courseObj->fetchRaw("*", " id = $courseObj->id ") as $course) {
        $courseData = array('id' => 'id', 'name' => 'fullname', 'image' => 'image', 'shortName' => 'shortname', 'category' => 'category', 'startDate' => 'startdate', 'description' => 'summary', 'status' => 'visible', 'amount' => 'amount');
        foreach ($courseData as $key => $value){
            switch ($key) { 
                case 'image': $contextId = Context::getContextId($dbMoObj, MOODLE_DB_PREFIX, CONTEXT_COURSE, $courseObj->id);
                              $courseObj->$key = MOODLE_URL.'pluginfile.php/'.$contextId.'/course/overviewfiles/'.Files::getCourseImage($dbMoObj, MOODLE_DB_PREFIX, $contextId);break;

                default     :   $courseObj->$key = $course[$value]; break; 
            }
        }
    }
    $courseObj->amount = Course::getSingle($dbObj, '', 'amount', " name = '".$courseObj->name."'");
    
    //set array of items you are selling, single or multiple
    $items = array( array('name'=> $courseObj->name, 'quantity'=> $courseQty, 'price'=> $courseObj->amount, 'sku'=> $courseObj->id, 'currency'=>PP_CURRENCY));
    $totalAmount = ($courseQty * $courseObj->amount);//calculate total amount of all quantity. 
    $_SESSION['currPaypalCourse'] = $courseObj->id;
    $_SESSION['currPaypalCourseName'] = $courseObj->name;
    
    //Check if the user has purchased the course before
    if(count($purchaseRecordObj->fetchRaw("*", " user = ".$_SESSION['IADETuserId']." AND course = $courseObj->id "))>0){ 
        $_SESSION['illegalOperation'] = "Illegal Operation! You have already purchased this course.";
        $thisPage->redirectTo('../courses-overview');
    }
    
    try{ // try a payment request //if payment method is paypal
        $result = create_paypal_payment($totalAmount, PP_CURRENCY, '', $items, RETURN_URL, CANCEL_URL);
        //if payment method was PayPal, we need to redirect user to PayPal approval URL
        if($result->state == "created" && $result->payer->payment_method == "paypal"){
            $_SESSION["payment_id"] = $result->id; //set payment id for later use, we need this to execute payment
            header("location: ". $result->links[1]->href); //after success redirect user to approval URL 
            exit();
        }

    }
    catch(PPConnectionException $ex) { echo parseApiError($ex->getData()); } catch (Exception $ex) { echo $ex->getMessage(); }
}

### After PayPal payment method confirmation, user is redirected back to this page with token and Payer ID ###
if(isset($_GET["token"]) && isset($_GET["PayerID"]) && isset($_SESSION["payment_id"])){
    try{
        $result = execute_payment($_SESSION["payment_id"], $_GET["PayerID"]);  //call execute payment function.

        if($result->state == "approved"){ //if state = approved continue..
            //SUCESS
            unset($_SESSION["payment_id"]); //unset payment_id, it is no longer needed 
            //get transaction details
            $transaction_id 		= $result->transactions[0]->related_resources[0]->sale->id;
            $transaction_time 		= $result->transactions[0]->related_resources[0]->sale->create_time;
            $transaction_currency 	= $result->transactions[0]->related_resources[0]->sale->amount->currency;
            $transaction_amount 	= $result->transactions[0]->related_resources[0]->sale->amount->total;
            $transaction_method 	= $result->payer->payment_method;
            $transaction_state 		= $result->transactions[0]->related_resources[0]->sale->state;

            //get payer details
            $payer_first_name 		= $result->payer->payer_info->first_name;
            $payer_last_name 		= $result->payer->payer_info->last_name;
            $payer_email 			= $result->payer->payer_info->email;
            $payer_id				= $result->payer->payer_info->payer_id;

            //get shipping details 
            $shipping_recipient		= $result->transactions[0]->item_list->shipping_address->recipient_name;
            $shipping_line1			= $result->transactions[0]->item_list->shipping_address->line1;
            $shipping_line2			= $result->transactions[0]->item_list->shipping_address->line2;
            $shipping_city			= $result->transactions[0]->item_list->shipping_address->city;

            $shipping_state			= $result->transactions[0]->item_list->shipping_address->state;
            $shipping_postal_code	= $result->transactions[0]->item_list->shipping_address->postal_code;
            $shipping_country_code	= $result->transactions[0]->item_list->shipping_address->country_code;

            $purchaseRecord = new PurchaseRecord($dbObj);
            //transaction_id, course, user, amount, currency, method, state, date_purchased
            $purchaseRecord->transactionId = $transaction_id;
            $purchaseRecord->course = $_SESSION['currPaypalCourse'];
            $purchaseRecord->user = $_SESSION['IADETuserId'];
            $purchaseRecord->amount = $transaction_amount;
            $purchaseRecord->currency = $transaction_currency;
            $purchaseRecord->method = $transaction_method;
            $purchaseRecord->state = $transaction_state;
            $purchaseRecord->datePurchased = $transaction_time;
            $purchaseRecord->add();//Update transaction record
            User::enrol($dbMoObj, MOODLE_DB_PREFIX, $_SESSION['IADETuserId'], time(), time(), time(), time(), $_SESSION['currPaypalCourse']);
            
            //Set session for later use, print_r($result); to see what is returned
            $_SESSION["results"]  = array(
                            'transaction_id' => $transaction_id, 
                            'transaction_time' => $transaction_time,
                            'transaction_currency' => $transaction_currency,
                            'transaction_amount' => $transaction_amount,
                            'transaction_method' => $transaction_method,
                            'transaction_state' => $transaction_state
                            );
            $subject = "Course Purchase Transaction Response [".$_SESSION["currPaypalCourseName"]."]";
            $message = "<strong>From:</strong>".WEBSITE_AUTHOR." <br/><br/> <strong>Message:</strong> You have successfully purchased ".$_SESSION["currPaypalCourseName"].
                        '. 
                        <style type="text/css">
                        .transaction_info {margin:0px auto; background:#F2FCFF;; max-width: 750px; color:#555;font-size: 13px;font-family: Arial, sans-serif;}
                        .transaction_info thead {background: #BCE4FA;font-weight: bold;}
                        .transaction_info thead tr th {border-bottom: 1px solid #ddd;}
                        </style>
                        <div align="center"><h2>Payment Success</h2></div>
                        <table border="0" cellpadding="10" cellspacing="0" class="transaction_info">
                        <thead><tr>
                        <td>Transaction ID</td>
                        <td>Date</td><td>Currency</td>
                        <td>Amount</td><td>Method</td>
                        <td>State</td></tr></thead>
                        <tbody>
                        <tr>
                        <td>'.$_SESSION["results"]["transaction_id"].'</td>
                        <td>'.$_SESSION["results"]["transaction_time"].'</td>
                        <td>'.$_SESSION["results"]["transaction_currency"].'</td>
                        <td>'.$_SESSION["results"]["transaction_amount"].'</td>
                        <td>'.$_SESSION["results"]["transaction_method"].'</td>
                        <td>'.$_SESSION["results"]["transaction_state"].'</td></tr><tr>
                        <td colspan="6">
                        <div align="center">
                        <a href="'.MOODLE_URL.'">Login to your account on IADET ecourse website now!</a></div></td></tr></tbody></table>'
                    . "<br/> For any enquiries contact us via <a href='mailto:$iadetEmail'>$iadetEmail</a>";
            $headers = 'From: '.WEBSITE_AUTHOR.'<' . $iadetEmail . '>' . "\r\n";
            $headers .= 'Reply-To: ' . $iadetEmail . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            mail($payer_email, $subject, $message, $headers);
            
            

                header("location: ". RETURN_URL); //$_SESSION["results"] is set, redirect back to order_process.php
                exit();
        }

    }
    catch(PPConnectionException $ex) { $ex->getData(); } catch (Exception $ex) { echo $ex->getMessage(); }
}
$redirectBack = MOODLE_URL;
### Display order confirmation if $_SESSION["results"] is set  ####
if(isset($_SESSION["results"])) {
$content = <<<EOD
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Course Purchase Response</title>
<style type="text/css">
.transaction_info {margin:0px auto; background:#F2FCFF;; max-width: 750px; color:#555;font-size: 13px;font-family: Arial, sans-serif;}
.transaction_info thead {background: #BCE4FA;font-weight: bold;}
.transaction_info thead tr th {border-bottom: 1px solid #ddd;}
</style>
</head>
<body>
<div align="center"><h2>Payment Success</h2></div>
<table border="0" cellpadding="10" cellspacing="0" class="transaction_info">
<thead><tr>
<td>Transaction ID</td>
<td>Date</td><td>Currency</td>
<td>Amount</td><td>Method</td>
<td>State</td></tr></thead>
<tbody>
<tr>
<td>{$_SESSION["results"]["transaction_id"]}</td>
<td>{$_SESSION["results"]["transaction_time"]}</td>
<td>{$_SESSION["results"]["transaction_currency"]}</td>
<td>{$_SESSION["results"]["transaction_amount"]}</td>
<td>{$_SESSION["results"]["transaction_method"]}</td>
<td>{$_SESSION["results"]["transaction_state"]}</td></tr><tr>
<td colspan="6">
<div align="center">
<a href="{$redirectBack}?id={$_SESSION["currPaypalCourse"]}">Proceed to eCourse Page</a></div></td></tr></tbody></table>
</body></html>	
</body>
</html>
EOD;
print $content;
}

unset($_SESSION["results"]); unset($_SESSION["currPaypalCourse"]);unset($_SESSION["currPaypalCourseName"]);
}
else{
    $_SESSION['illegalOperation'] = 'Illegal Operation! Please login or register to purchase courses on this site.'; 
    $thisPage->redirectTo('../courses-overview');
}
?>
