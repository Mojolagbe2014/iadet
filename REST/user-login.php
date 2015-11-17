<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Create an object of User class
$filesObj = new Files($dbMoObj, MOODLE_DB_PREFIX);
$errorArr = array(); //Array of errors

if(filter_input(INPUT_POST, "loginstuff")!=NULL){
    $postVars = array('email','passWord'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'passWord':$userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
            default     :   $userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        
        if($userObj->emailExists()){
            $logingInUser = json_decode($userObj->fetch("*", "  email = '".$userObj->email."' AND confirmed = 1 ", " id LIMIT 1 ", $filesObj));
            $userObj->id = $logingInUser->info[0]->id;
            if(password_verify($userObj->passWord, $logingInUser->info[0]->passWord)){//$userObj->pwdExists()
                $_SESSION['IADETLoggedIn'] = true; $_SESSION['IADETUserName'] = $logingInUser->info[0]->userName;
                $_SESSION['IADETuserId'] = $logingInUser->info[0]->id; $_SESSION['IADETuserEmail'] = $logingInUser->info[0]->email;
                header('Content-type: application/json');
                echo json_encode($logingInUser);
            }
            else{ 
                echo json_encode(array("status" => 2, "msg" => "Reason: Incorrect Password."));    
            }
        }
        else{ 
            $json = array("status" => 0, "msg" => 'The email you entered does not exist in our database.'); 
            $dbMoObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    }
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }
} else{ 
        $json = array("status" => 0, "msg" => "Login Failed. Unrecognized attempt."); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }