<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$userCourseObj = new UserCourse($dbObj); // Create an object of User class
$errorArr = array(); //Array of errors

if(filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT)!=NULL){ 
    //fetch all users
    echo $userCourseObj->fetch("*", " user=".filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT), " date_registered ");
}
else{
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}