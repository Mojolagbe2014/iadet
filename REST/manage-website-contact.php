<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteContactObj = new WebsiteContact($dbObj); // Create an object of WebsiteContact class
$errorArr = array(); //Array of errors

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchWebsiteContact") != NULL){
        //fetch all websiteContacts
        echo $websiteContactObj->fetch();
    }
    
    if(filter_input(INPUT_POST, "updateThisContact") != NULL){
        $postVars = array('id', 'title', 'description', 'keywords', 'phone','email','address'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $websiteContactObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($websiteContactObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo $websiteContactObj->update();
        }
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}