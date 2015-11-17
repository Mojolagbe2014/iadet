<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Create an object of User class
$errorArr = array(); //Array of errors

if(isset($_SESSION["IADETuserEmail"])){
    session_destroy();
    $json = array("status" => 1, "msg" => "Logout successful."); 
    $dbMoObj->close();//Close Database Connection
    header('Content-type: application/json');
    echo json_encode($json);
}else{
    $json = array("status" => 0, "msg" => "Logout failed."); 
    $dbMoObj->close();//Close Database Connection
    header('Content-type: application/json');
    echo json_encode($json);
}