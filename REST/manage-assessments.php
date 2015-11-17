<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$assessmentObj = new Assessment($dbObj); // Create an object of Assessment class
$errorArr = array(); //Array of errors
$oldAttachment=""; $newAttachment =""; $assessmentFil="";

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchAssessments") != NULL){
        $requestData= $_REQUEST;
        $columns = array( 0 =>'id', 1 => 'status', 2 => 'leson', 3 => 'title', 4 => 'question', 5 => 'mark', 6 => 'submission_date', 7 => 'attachment',  8 => 'date_added');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM assessment ");
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM assessment WHERE 1=1 "; //id, name, short_name, category, start_date, code, description, media, amount, date_registered
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( title LIKE '%".$requestData['search']['value']."%' ";    
                $sql.=" OR question LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR submission_date LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR attachment LIKE '".$requestData['search']['value']."' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

        echo $assessmentObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    
    if(filter_input(INPUT_POST, "deleteThisAssessment")!=NULL){
        $postVars = array('id',  'attachment'); // Form fields names
        $assessmentAttachment = "";
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'attachment':$assessmentObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                $assessmentAttachment = $assessmentObj->$postVar;
                                //if($assessmentObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $assessmentObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($assessmentObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $attachmentDelParam = true;
            if(!empty($assessmentAttachment) && file_exists(MEDIA_FILES_PATH."assessment/".$assessmentAttachment)){
                if(unlink(MEDIA_FILES_PATH."assessment/".$assessmentAttachment)){ $attachmentDelParam = true;}
                else { $attachmentDelParam = false; }
            }
            if($attachmentDelParam == true){ echo $assessmentObj->delete(); }
            else{ 
                $json = array("status" => 0, "msg" => $errorArr); 
                $dbObj->close();//Close Database Connection
                header('Content-type: application/json');
                echo json_encode($json);
            }
        }
        else{ //Else show error messages
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    } 
    
    if(filter_input(INPUT_GET, "activateAssessment")!=NULL){
        $postVars = array('id', 'status'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'status':  $assessmentObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($assessmentObj->$postVar == 1) {$assessmentObj->$postVar = 0;} 
                                elseif($assessmentObj->$postVar == 0) {$assessmentObj->$postVar = 1;}
                                break;
                default     :   $assessmentObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($assessmentObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo Assessment::updateSingle($dbObj, ' status ',  $assessmentObj->status, $assessmentObj->id); 
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    
    if(filter_input(INPUT_POST, "updateThisAssessment") != NULL){
        $postVars = array('id','lesson', 'title','question','submissionDate','mark','attachment');  // Form fields names
        $oldAttachment = $_REQUEST['oldAttachment'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'attachment':   $newAttachment = basename($_FILES["attachment"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'title'))).".".pathinfo(basename($_FILES["attachment"]["name"]),PATHINFO_EXTENSION): ""; 
                                $assessmentObj->$postVar = $newAttachment;
                                if($assessmentObj->$postVar == "") { $assessmentObj->$postVar = $oldAttachment;}
                                $assessmentFil = $newAttachment;
                                break;
                default     :   $assessmentObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($assessmentObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetAttachment = MEDIA_FILES_PATH."/assessment/". $assessmentFil;
            $uploadOk = 1; $msg = '';
            if($newAttachment !=""){
                if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetAttachment)) {
                    $msg .= "The file ". basename( $_FILES["attachment"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(!empty($oldAttachment) && file_exists(MEDIA_FILES_PATH."assessment/".$oldAttachment)) unlink(MEDIA_FILES_PATH."assessment/".$oldAttachment); $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
            if($uploadOk == 1){
                echo $assessmentObj->update();
            }
            else {
                    $msg = " Sorry, there was an error uploading your assessment attachment. ERROR: ".$msg;
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
}