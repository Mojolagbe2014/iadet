<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteServicesObj = new WebsiteServices($dbObj); // Create an object of WebsiteServices class
$errorArr = array(); //Array of errors
$newContentImage = ''; $oldContentImage = '';
if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchWebsiteServices") != NULL){
        //fetch all websiteServicess
        echo $websiteServicesObj->fetch();
    }
    
    if(filter_input(INPUT_POST, "updateThisServices") != NULL){
        $postVars = array('id', 'title', 'description', 'keywords', 'contentHeader','content','contentImage','firstTabHeader','secondTabHeader','thirdTabHeader','firstTabContent','secondTabContent','thirdTabContent'); // Form fields names
        $oldContentImage = $_REQUEST['oldContentImage'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'contentImage':   $newContentImage = basename($_FILES["contentImage"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", 'our services image')).".".pathinfo(basename($_FILES["contentImage"]["name"]),PATHINFO_EXTENSION): ""; 
                                $websiteServicesObj->$postVar = $newContentImage;
                                if($websiteServicesObj->$postVar == "") { $websiteServicesObj->$postVar = $oldContentImage;}
                                break;
                default     :   $websiteServicesObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($websiteServicesObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetContentImage = MEDIA_FILES_PATH."web-page/services/". $newContentImage;
            $uploadOk = 1; $msg = '';
            if($newContentImage !=""){
                if (move_uploaded_file($_FILES["contentImage"]["tmp_name"], $targetContentImage)) {
                    $msg .= "The file ". basename( $_FILES["contentImage"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."web-page/services/".$oldContentImage)) unlink(MEDIA_FILES_PATH."web-page/services/".$oldContentImage); $uploadOk = 1;
                } else { $uploadOk = 0; }
            }
            if($uploadOk == 1){  echo $websiteServicesObj->update(); }
            else {
                    $msg = " Sorry, there was an error uploading your website services page media. ERROR: ".$msg;
                    $json = array("status" => 0, "msg" => $msg); 
                    $dbObj->close();//Close Database Connection
                    header('Content-type: application/json');
                    echo json_encode($json);
            }
           
        }
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}