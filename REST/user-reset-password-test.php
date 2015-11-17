<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
require '../swiftmailer/lib/swift_required.php';
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Cject of User class
$errorArr = array(); //Array of errors
$newPassword ="";
//if(mail("mojolagbe@yahoo.com", "Test Values", "Testing")){echo "Sent!!!";};
// Create the mail transport configuration
$transport = Swift_MailTransport::newInstance();

// Create the message
$message = Swift_Message::newInstance();
$message->setTo(array("aurelioderosa@gmail.com" => "Aurelio De Rosa"));
$message->setSubject("This email is sent using Swift Mailer");
$message->setBody("You're our best client ever.");
$message->setFrom("account@bank.com", "Your bank");

// Send the email
$mailer = Swift_Mailer::newInstance($transport);
$mailer->send($message);

if(isset($_GET['email'])){
    $postVars = array('email'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'email':   $userObj->email = $_GET['email'] ? $_GET['email'] :  ''; 
                            if($userObj->email == "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        $userObj->passWord = '@Rst#'.time();
        $newPassword = $userObj->passWord;
        $emailAddress = $_GET['email'];
        $subject = "Message From: Admin IADET";	
        $message = "<strong>Message:</strong> Your password has been reset. Email: ".$emailAddress." <br/> Password: ".$newPassword;
        $headers = 'From: Admin IADET <info@iadet.net>' . "\r\n";
        $headers .= 'Reply-To: info@iadet.net' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail("jbmojolagbe@nigerianseminarsandtrainings.com", $subject, $message, $headers);
        echo  $userObj->resetPassword();
    }
    //Else show error messages
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }

}