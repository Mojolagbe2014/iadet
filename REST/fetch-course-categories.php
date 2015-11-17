<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseCategoryObj = new CourseCategory($dbMoObj, MOODLE_DB_PREFIX); // Create an object of CourseCategory class
$errorArr = array(); //Array of errors

$categoryParent = filter_input(INPUT_GET, "parent", FILTER_VALIDATE_INT)  ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, "parent", FILTER_VALIDATE_INT)) :  0;
$parentParam = 'parent = 0';
if($categoryParent != 0){ $parentParam = 'parent != 0'; }

//fetch all users
header('Content-type: application/json');
echo $courseCategoryObj->fetch("*", " 1=1 AND $parentParam ", " id ", $dbObj);