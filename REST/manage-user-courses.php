<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$userCourseObj = new UserCourse($dbObj); // Create an object of User class
$errorArr = array(); //Array of errors
$oldMedia =''; $newMedia = ''; $oldCertificate = ''; $newCertificate = '';

if(filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT)!=NULL && filter_input(INPUT_GET, "action") == "fetch"){ 
    //fetch all users'courses
    $userCourseObj->user = filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT);
    header('Content-type: application/json');
    echo $userCourseObj->fetch("*", " user = ".$userCourseObj->user, " id ");
}
elseif(filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT)!=NULL && filter_input(INPUT_GET, "action") == "count"){ 
    //fetch all users'courses count
    $userCourseObj->user = filter_input(INPUT_GET, "LoggedInUserId", FILTER_VALIDATE_INT);
    header('Content-type: application/json');
    echo $userCourseObj->getUserCourseCount();
}
elseif(filter_input(INPUT_POST, "LoggedInUserId", FILTER_VALIDATE_INT)!=NULL && filter_input(INPUT_POST, "action") == "update"){ 
    $postVars = array('id','user','topic','speciality','attendanceDate','point','location','comment','certificate'); // Form fields names
    $oldCertificate = $_REQUEST['oldCertificate'];
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'certificate': $newCertificate = basename($_FILES["certificate"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'topic'))).".".pathinfo(basename($_FILES["certificate"]["name"]),PATHINFO_EXTENSION): ""; 
                                $userCourseObj->$postVar = $newCertificate;
                                if($userCourseObj->$postVar == "") {$userCourseObj->$postVar = $oldCertificate;}
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
        $targetCertificate = MEDIA_FILES_PATH."/user-course-certificate/". $newCertificate;
        $uploadOk = 1; $msg = '';

        if($newCertificate !=""){
            if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $targetCertificate)) {
                $msg .= "The file ". basename( $_FILES["certificate"]["name"]). " has been uploaded.";
                $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."user-course-certificate/".$oldCertificate) && $oldCertificate !='')unlink(MEDIA_FILES_PATH."user-course-certificate/".$oldCertificate); $uploadOk = 1;
            } else { $uploadOk = 0; }
        }

        if($uploadOk == 1){ echo $userCourseObj->update(); }
        else {
                $msg = " Sorry, there was an error uploading your course media. ERROR: ".$msg;
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
else{
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}