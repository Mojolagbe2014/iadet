<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$lessonObj = new Lesson($dbObj); // Create an object of Lesson class
$errorArr = array(); //Array of errors
$lessonImgFil ="";
if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "addNewLesson") != NULL){
        $postVars = array('form','title','body','startDate','endDate','tutor','material','parent'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'material':   $lessonObj->$postVar = basename($_FILES["material"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'title'))).".".pathinfo(basename($_FILES["material"]["name"]),PATHINFO_EXTENSION): ""; 
                                $lessonImgFil = $lessonObj->$postVar;
                                if($lessonObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $lessonObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($lessonObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetFile = MEDIA_FILES_PATH."/lesson/". $lessonImgFil;
            $uploadOk = 1; $msg = '';
            $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            if (file_exists($targetFile)) { $msg .= " Lesson material already exists."; $uploadOk = 0; }
            if ($_FILES["material"]["size"] > 80000000) { $msg .= " Lesson material is too large."; $uploadOk = 0; }
            if ($uploadOk == 0) {
                $msg = "Sorry, your lesson material was not uploaded. ERROR: ".$msg;
                $json = array("status" => 0, "msg" => $msg); 
                header('Content-type: application/json');
                echo json_encode($json);
            } 
            else {
                if (move_uploaded_file($_FILES["material"]["tmp_name"], $targetFile)) {
                    $msg .= "The material has been uploaded.";
                    $status = 'ok';
                    echo $lessonObj->add();
                } else {
                    $msg = " Sorry, there was an error uploading your lesson material. ERROR: ".$msg;
                    $json = array("status" => 0, "msg" => $msg); 
                    $dbObj->close();//Close Database Connection
                    header('Content-type: application/json');
                    echo json_encode($json);
                }
            }

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