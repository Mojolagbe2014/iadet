<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteWhatWeDoObj = new WebsiteWhatWeDo($dbObj); // Create an object of WebsiteWhatWeDo class
$errorArr = array(); //Array of errors
$oldTopBackGround = ""; $newTopBackGround =""; 

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchWebsiteWhatWeDo") != NULL){
        //fetch all websiteWhatWeDos
        echo $websiteWhatWeDoObj->fetch();
    }
    
    if(filter_input(INPUT_POST, "updateThisWhatWeDo") != NULL){
        $postVars = array('id', 'title', 'description', 'keywords', 'topBackGround','topHeader','topFirstText','topSecondText','topThirdText','topFourthText','contentHeader','content'); // Form fields names
        $oldTopBackGround = $_REQUEST['oldTopBackGround']; 
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'topBackGround':   $newTopBackGround = basename($_FILES["topBackGround"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", 'top slider background')).".".pathinfo(basename($_FILES["topBackGround"]["name"]),PATHINFO_EXTENSION): ""; 
                                $websiteWhatWeDoObj->$postVar = $newTopBackGround;
                                if($websiteWhatWeDoObj->$postVar == "") { $websiteWhatWeDoObj->$postVar = $oldTopBackGround;}
                                break;
                default     :   $websiteWhatWeDoObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($websiteWhatWeDoObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            //$target_dir = "../project-files/";
            $targetTopBackGround = MEDIA_FILES_PATH."web-page/what-we-do/". $newTopBackGround;
            $uploadOk = 1; $msg = '';
            
            if($newTopBackGround !=""){
                if (move_uploaded_file($_FILES["topBackGround"]["tmp_name"], $targetTopBackGround)) {
                    $msg .= "The file ". basename( $_FILES["topBackGround"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."web-page/what-we-do/".$oldTopBackGround)) unlink(MEDIA_FILES_PATH."web-page/what-we-do/".$oldTopBackGround); $uploadOk = 1;
                } else { $uploadOk = 0; }
            }
            if($uploadOk == 1){ echo $websiteWhatWeDoObj->update(); }
            else {
                    $msg = " Sorry, there was an error uploading your websiteWhatWeDo media. ERROR: ".$msg;
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