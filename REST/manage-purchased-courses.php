<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbObjs = new Database();//Instantiate database

$userPurchaseRecObj = new PurchaseRecord($dbObj); // Create an object of User class\
$userPurchaseRecObjs = new PurchaseRecord($dbObjs); // Create an object of User class
$errorArr = array(); //Array of errors

if(filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT)!=NULL && filter_input(INPUT_GET, "action") == "fetch"){ 
    //fetch all users'courses
    $userPurchaseRecObj->user = filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT);
    $userPurchaseRecObjs->user = filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT);
    
    $nonInstallmentCourses = json_decode($userPurchaseRecObj->fetch("*", " user = $userPurchaseRecObj->user AND mode != 'installment' ", " id "), true);
    
    $installmentCourses = json_decode($userPurchaseRecObjs->fetch("*", " user = $userPurchaseRecObjs->user AND mode = 'installment' GROUP BY course ", " id "), true);
    $resultCourses = array();
    if($installmentCourses['status'] == 1 && $nonInstallmentCourses['status'] == 1){
        unset($nonInstallmentCourses['status']);
        $resultCourses = array_merge_recursive($installmentCourses, $nonInstallmentCourses);
    }else if($installmentCourses['status'] == 1 && $nonInstallmentCourses['status'] == 2){
        $resultCourses = $installmentCourses;
    }else if($installmentCourses['status'] == 2 && $nonInstallmentCourses['status'] == 1){
        $resultCourses = $nonInstallmentCourses;
    }else if($installmentCourses['status'] == 2 && $nonInstallmentCourses['status'] == 2){
        $resultCourses = $nonInstallmentCourses;
    }
    header('Content-type: application/json');
    echo json_encode($resultCourses);
}
elseif(filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT)!=NULL && filter_input(INPUT_GET, "action") == "count"){ 
     //fetch all users'purchased courses count
    $userPurchaseRecObj->user = filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT);
    header('Content-type: application/json');
    echo $userPurchaseRecObj->getPurchasedCourseCount();
}
else{
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}