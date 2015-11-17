<?php
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseObj = new Course($dbMoObj, MOODLE_DB_PREFIX);

$totalNo = filter_input(INPUT_GET, "totalNo", FILTER_VALIDATE_INT) 
        ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, "totalNo", FILTER_VALIDATE_INT)) :  100;
$offset = filter_input(INPUT_GET, "offset", FILTER_VALIDATE_INT) 
        ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, "offset", FILTER_VALIDATE_INT)) :  0;
$category = filter_input(INPUT_GET, "category", FILTER_VALIDATE_INT)
        ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, "category", FILTER_VALIDATE_INT)) :  0;

if($category != 0) { 
    //echo $courseObj->fetch("*", " visible=1 AND category = $category ", " id LIMIT $totalNo OFFSET $offset ", $dbObj); 
    echo $courseObj->fetchByCategoryJSON($category, MOODLE_DB_PREFIX.'course_categories', $dbObj, " AND visible=1 ORDER BY id LIMIT $totalNo OFFSET $offset");
}

else{ echo $courseObj->fetch("*", " visible=1 AND category !=0 AND format !='site' ", " id LIMIT $totalNo OFFSET $offset ", $dbObj); }