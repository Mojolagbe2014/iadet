<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$cartItemObj = new CartItem($dbObj); // Create an object of CartItem class
$errorArr = array(); //Array of errors

if(!isset($_SESSION['IADETUserName']) && !isset($_SESSION['IADETuserEmail'])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "course")!=NULL){
        $cartItemObj->user = $_SESSION['IADETuserId'] ? $_SESSION['IADETuserId'] : array_push ($errorArr, "Error 1 ");
        $cartItemObj->course = filter_input(INPUT_POST, 'course', FILTER_VALIDATE_INT) ? filter_input(INPUT_POST, 'course', FILTER_VALIDATE_INT) : array_push ($errorArr, "Error 2 ");
        
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo $cartItemObj->delete();
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    } 
}