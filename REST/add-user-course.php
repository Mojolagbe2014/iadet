<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$userCourseObj = new UserCourse($dbObj); // Create an object of UserCourse class
$errorArr = array(); //Array of errors
$courseMedFil =""; $courseCertFil="";
if(filter_input(INPUT_POST, "LoggedInUserId", FILTER_VALIDATE_INT)==NULL){ 
    $json = array("status" => 4, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    $postVars = array('user','topic','speciality','attendanceDate','point','location','comment','certificate'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'certificate': $userCourseObj->$postVar = basename($_FILES["certificate"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'topic'))).".".pathinfo(basename($_FILES["certificate"]["name"]),PATHINFO_EXTENSION): ""; 
                                $courseCertFil = $userCourseObj->$postVar;
                                break;
            case 'comment': $userCourseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            break;
            default     :   $userCourseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userCourseObj->$postVar === "") {array_push ($errorArr, "$postVar");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        $targetCerficate = MEDIA_FILES_PATH."/user-course-certificate/". $courseCertFil;
        $uploadOk = 1; $msg = '';
       
        if($targetCerficate!= ''){
          move_uploaded_file($_FILES["certificate"]["tmp_name"], $targetCerficate);
        }
        
        if ($uploadOk == 1) {
                echo $userCourseObj->add();
        } else {
                $msg = " ERROR: ".$msg;
                $json = array("status" => 0, "msg" => $msg); 
                $dbObj->close();//Close Database Connection
                header('Content-type: application/json');
                echo json_encode($json);
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