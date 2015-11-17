<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$cartItemObj = new CartItem($dbObj); // Create an object of CartItem class
$errorArr = array(); //Array of errors

if(!isset($_SESSION['IADETUserName']) || !isset($_SESSION["IADETuserEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in. Please sign in to be able to perform this action."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "addNewCartItem") != NULL){
        $postVars = array('user', 'course'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'user':    $cartItemObj->$postVar = $_SESSION['IADETuserId'] ? $_SESSION['IADETuserId'] : ''; 
                                if($cartItemObj->$postVar == "") {array_push ($errorArr, "You have to login ");}
                                break;
                default     :   $cartItemObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($cartItemObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo $cartItemObj->add();
        }
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}