<?php
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseObj = new Course($dbMoObj, MOODLE_DB_PREFIX);

$courseId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) 
        ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)) :  0;


if($courseId != 0) { echo $courseObj->fetch("*", " visible = 1 AND category > 0 AND id = $courseId ", 'id', $dbObj); }
else{
    $json = array("status" => 0, "msg" => "Illegal Operation."); 
    header('Content-type: application/json');
    echo json_encode($json);
}