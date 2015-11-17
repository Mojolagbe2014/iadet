<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteIndexObj = new WebsiteIndex($dbObj); // Create an object of WebsiteIndex class
$errorArr = array(); //Array of errors
$oldTopBackGround = ""; $newTopBackGround =""; $oldTopLogo=""; $newTopLogo =""; $websiteIndexImageFil="";
$oldBottomBackGround = ""; $newBottomBackGround =""; $oldBottomVideo=""; $newBottomVideo ="";

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in.");
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchWebsiteIndex") != NULL){
        //fetch all websiteIndexs
        echo $websiteIndexObj->fetch();
    }
    
    if(filter_input(INPUT_POST, "updateThisIndex") != NULL){
        $postVars = array('id', 'title', 'description', 'keywords', 'topBackGround','topLogo','topH1','topH3','bottomBackGround','bottomH1','bottomH2','bottomVideo'); // Form fields names
        $oldTopBackGround = $_REQUEST['oldTopBackGround']; $oldTopLogo = $_REQUEST['oldTopLogo'];
        $oldBottomBackGround = $_REQUEST['oldBottomBackGround']; $oldBottomVideo = $_REQUEST['oldBottomVideo'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'topBackGround':   $newTopBackGround = basename($_FILES["topBackGround"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", 'top slider background')).".".pathinfo(basename($_FILES["topBackGround"]["name"]),PATHINFO_EXTENSION): ""; 
                                $websiteIndexObj->$postVar = $newTopBackGround;
                                if($websiteIndexObj->$postVar == "") { $websiteIndexObj->$postVar = $oldTopBackGround;}
                                break;
                case 'topLogo':   $newTopLogo = basename($_FILES["topLogo"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", 'top slider logo')).".".pathinfo(basename($_FILES["topLogo"]["name"]),PATHINFO_EXTENSION): ""; 
                                $websiteIndexObj->$postVar = $newTopLogo;
                                if($websiteIndexObj->$postVar == "") { $websiteIndexObj->$postVar = $oldTopLogo;}
                                break;
                case 'bottomBackGround':   $newBottomBackGround = basename($_FILES["bottomBackGround"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", 'bottom slider background')).".".pathinfo(basename($_FILES["bottomBackGround"]["name"]),PATHINFO_EXTENSION): ""; 
                                $websiteIndexObj->$postVar = $newBottomBackGround;
                                if($websiteIndexObj->$postVar == "") { $websiteIndexObj->$postVar = $oldBottomBackGround;}
                                break;
                case 'bottomVideo':   $newBottomVideo = basename($_FILES["bottomVideo"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", 'bottom slider video')).".".pathinfo(basename($_FILES["bottomVideo"]["name"]),PATHINFO_EXTENSION): ""; 
                                $websiteIndexObj->$postVar = $newBottomVideo;
                                if($websiteIndexObj->$postVar == "") { $websiteIndexObj->$postVar = $oldBottomVideo;}
                                break;
                default     :   $websiteIndexObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($websiteIndexObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            //$target_dir = "../project-files/";
            $targetTopBackGround = MEDIA_FILES_PATH."web-page/index/". $newTopBackGround;
            $targetTopLogo = MEDIA_FILES_PATH."web-page/index/". $newTopLogo;
            $targetBottomBackGround = MEDIA_FILES_PATH."web-page/index/". $newBottomBackGround;
            $targetBottomVideo = MEDIA_FILES_PATH."web-page/index/". $newBottomVideo;
            $uploadOk = 1; $msg = '';
            
            if($newTopBackGround !=""){
                if (move_uploaded_file($_FILES["topBackGround"]["tmp_name"], $targetTopBackGround)) {
                    $msg .= "The file ". basename( $_FILES["topBackGround"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."web-page/index/".$oldTopBackGround)) unlink(MEDIA_FILES_PATH."web-page/index/".$oldTopBackGround); $uploadOk = 1;
                } else { $uploadOk = 0; }
            }
            if($newTopLogo !=""){
                if (move_uploaded_file($_FILES["topLogo"]["tmp_name"], $targetTopLogo)) {
                    $msg .= "The file ". basename( $_FILES["topLogo"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."web-page/index/".$oldTopLogo))unlink(MEDIA_FILES_PATH."web-page/index/".$oldTopLogo); $uploadOk = 1;
                } else { $uploadOk = 0; }
            }
            if($newBottomBackGround !=""){
                if (move_uploaded_file($_FILES["bottomBackGround"]["tmp_name"], $targetBottomBackGround)) {
                    $msg .= "The file ". basename( $_FILES["bottomBackGround"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."web-page/index/".$oldBottomBackGround)) unlink(MEDIA_FILES_PATH."web-page/index/".$oldBottomBackGround); $uploadOk = 1;
                } else { $uploadOk = 0; }
            }
            if($newBottomVideo !=""){
                if (move_uploaded_file($_FILES["bottomVideo"]["tmp_name"], $targetBottomVideo)) {
                    $msg .= "The file ". basename( $_FILES["bottomVideo"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."web-page/index/".$oldBottomVideo)) unlink(MEDIA_FILES_PATH."web-page/index/".$oldBottomVideo); $uploadOk = 1;
                } else { $uploadOk = 0; }
            }
            
            if($uploadOk == 1){ echo $websiteIndexObj->update(); }
            else {
                    $msg = " Sorry, there was an error uploading your websiteIndex media. ERROR: ".$msg;
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