<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Create an object of User class
$dbObj = new Database();//Instantiate database
$purchaseCourseObj = new PurchaseRecord($dbObj); // Create an object of Admin class
$categoryObj = new CourseCategory($dbMoObj, MOODLE_DB_PREFIX);

$errorArr = array(); //Array of errors
$iadetEmail = WebsiteContact::getSingle($dbObj, 'email', 1);
if(filter_input(INPUT_POST, 'method') == 'Manual Log'){ $_SESSION['IADETuserId'] =  filter_input(INPUT_POST, 'user');}
$installmentCounter = 0;

if(filter_input(INPUT_POST, "user") != NULL){
    $postVars = array('user','course', 'itemType', 'method', 'state', 'mode', 'transactionId', 'currency', 'datePurchased', 'amount'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'itemType' :   $purchaseCourseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  '';
                                if($purchaseCourseObj->$postVar == 'sub-category'){ $purchaseCourseObj->$postVar = 'category';}
                                break;
            default     :   $purchaseCourseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            //if($purchaseCourseObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        
        //Check if the user has purchased the course before
        if(count($purchaseCourseObj->fetchRaw("*", " user = ".$_SESSION['IADETuserId']." AND course = $purchaseCourseObj->course AND item_type = '$purchaseCourseObj->itemType' AND mode = 'full' "))>0){ 
            $json = array("status" => 0, "msg" => 'This course has already been purchased by this user.'); 
            $dbObj->close(); header('Content-type: application/json'); echo json_encode($json); exit();
        }

        $installmentCounter = count($purchaseCourseObj->fetchRaw("*", " user = ".$_SESSION['IADETuserId']." AND course = $purchaseCourseObj->course AND item_type = '$purchaseCourseObj->itemType' AND mode = 'installment' "));
        if($installmentCounter > 3){ 
            $json = array("status" => 0, "msg" => 'Payment for the course category is already completed by this user.'); 
            $dbObj->close();
            header('Content-type: application/json');
            echo json_encode($json); exit();
        }
        
        if($purchaseCourseObj->itemType == 'course'){
            User::enrol($dbMoObj, MOODLE_DB_PREFIX, $_SESSION['IADETuserId'], time(), time(), time(), time(), $purchaseCourseObj->course);
        } elseif($purchaseCourseObj->itemType == 'category' && $installmentCounter == 0){
            User::enrolCategory($dbMoObj, MOODLE_DB_PREFIX, $_SESSION['IADETuserId'], time(), time(), time(), time(), $purchaseCourseObj->course);
        }

        //Set session for later use, print_r($result); to see what is returned
        $_SESSION["results"]  = array(
                        'transaction_id' => $purchaseCourseObj->transactionId, 
                        'transaction_time' => $purchaseCourseObj->datePurchased,
                        'transaction_currency' => $purchaseCourseObj->currency,
                        'transaction_amount' => $purchaseCourseObj->amount,
                        'transaction_method' => $purchaseCourseObj->method,
                        'transaction_state' => $purchaseCourseObj->state
                        );
        $subject = "Course Purchase Transaction Response ";
        $message = "<strong>From:</strong>".WEBSITE_AUTHOR." <br/><br/> <strong>Message:</strong> You have successfully purchased ".Course::getSingle($dbMoObj, MOODLE_DB_PREFIX, 'fullname', " id = ".$purchaseCourseObj->course).
                    ' on '.$purchaseCourseObj->mode. ' Payment Mode <br/>
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
        //mail($payer_email, $subject, $message, $headers);
        unset($_SESSION["results"]);
        echo $purchaseCourseObj->add();
    }
    //Else show error messages
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }
} 