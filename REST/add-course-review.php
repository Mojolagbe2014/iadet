<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$courseReviewObj = new CourseReview($dbObj); // Create an object of CourseReview class
$errorArr = array(); //Array of errors

if(filter_input(INPUT_POST, "addNewCourseReview") != NULL){
    $postVars = array('course', 'name', 'email', 'review'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'email': $courseReviewObj->$postVar = filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL)) :  ''; 
                            if($courseReviewObj->$postVar === "") {array_push ($errorArr, " valid $postVar ");}
            
            default     :   $courseReviewObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($courseReviewObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        echo $courseReviewObj->add();
    }
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }
} 
