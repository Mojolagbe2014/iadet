<?php
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Create an object of User class
$errorArr = array(); //Array of errors

if(filter_input(INPUT_POST, "id") != NULL){
    $postVars = array('firstName', 'lastName','phone','address','id'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            default     :   $userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        echo $userObj->update();
    }
    //Else show error messages
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }
} 