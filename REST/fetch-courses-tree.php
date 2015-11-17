<?php
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$coursCatObj = new CourseCategory($dbObj); // Create an object of CourseCategory class
$errorArr = array(); //Array of errors


//fetch all Categories and their subs

echo $coursCatObj->fetchChildren();
