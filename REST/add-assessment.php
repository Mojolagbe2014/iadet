<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$assessmentObj = new Assessment($dbObj); // Create an object of Assessment class
$errorArr = array(); //Array of errors
$assessmentAttachmt ="";
if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "addNewAssessment") != NULL){
        $postVars = array('lesson', 'title','question','submissionDate','mark','attachment'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'attachment':   $assessmentObj->$postVar = basename($_FILES["attachment"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'title'))).".".pathinfo(basename($_FILES["attachment"]["name"]),PATHINFO_EXTENSION): ""; 
                                $assessmentAttachmt = $assessmentObj->$postVar;
                                //if($assessmentObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $assessmentObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($assessmentObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetFile = MEDIA_FILES_PATH."/assessment/". $assessmentAttachmt;
            $uploadOk = 1; $msg = '';
            $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            if (!empty($assessmentAttachmt) && file_exists($targetFile)) { $msg .= " Assessment attachment already exists."; $uploadOk = 0; }
            if (!empty($assessmentAttachmt) && $_FILES["attachment"]["size"] > 80000000) { $msg .= " Assessment attachment is too large."; $uploadOk = 0; }
            if ($uploadOk == 0) {
                $msg = "Sorry, your assessment attachment was not uploaded. ERROR: ".$msg;
                $json = array("status" => 0, "msg" => $msg); 
                header('Content-type: application/json');
                echo json_encode($json);
            } 
            else {
                if (!empty($assessmentAttachmt)) {
                    move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile);
                    $msg .= "The attachment has been uploaded.";
                    $status = 'ok';
                    echo $assessmentObj->add();
                } else {
                    echo $assessmentObj->add();
                }
            }

        }
        else{ //Else show error messages
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}