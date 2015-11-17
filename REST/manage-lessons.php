<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$lessonObj = new Lesson($dbObj); // Create an object of Lesson class
$errorArr = array(); //Array of errors
$oldMaterial=""; $newMaterial =""; $lessonMaterialFil="";

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchLessons") != NULL){
        $requestData= $_REQUEST;
        $columns = array( 0 =>'id', 1 => 'status', 2 => 'title', 3 => 'form', 4 => 'parent', 5 => 'body', 6 => 'start_date', 7 => 'end_date',  8 => 'tutor', 9 => 'material', 10 => 'date_added');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM lesson ");
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM lesson WHERE 1=1 "; //id, name, short_name, category, start_date, code, description, media, amount, date_registered
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( title LIKE '%".$requestData['search']['value']."%' ";    
                $sql.=" OR body LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR start_date LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR end_date LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR material LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR form LIKE '".$requestData['search']['value']."' ";
                $sql.=" OR parent LIKE '".$requestData['search']['value']."' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

        echo $lessonObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    
    if(filter_input(INPUT_POST, "deleteThisLesson")!=NULL){
        $postVars = array('id',  'material'); // Form fields names
        $lessonMaterial = "";
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'material':$lessonObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                $lessonMaterial = $lessonObj->$postVar;
                                if($lessonObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $lessonObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($lessonObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1 && $lessonMaterial != "")   {
            $materialDelParam = true;
            if(file_exists(MEDIA_FILES_PATH."lesson/".$lessonMaterial)){
                if(unlink(MEDIA_FILES_PATH."lesson/".$lessonMaterial)){ $materialDelParam = true;}
                else { $materialDelParam = false; }
            }
            if($materialDelParam == true){ echo $lessonObj->delete(); }
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
    
    if(filter_input(INPUT_GET, "activateLesson")!=NULL){
        $postVars = array('id', 'status'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'status':  $lessonObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($lessonObj->$postVar == 1) {$lessonObj->$postVar = 0;} 
                                elseif($lessonObj->$postVar == 0) {$lessonObj->$postVar = 1;}
                                break;
                default     :   $lessonObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($lessonObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo Lesson::updateSingle($dbObj, ' status ',  $lessonObj->status, $lessonObj->id); 
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    
    if(filter_input(INPUT_POST, "updateThisLesson") != NULL){
        $postVars = array('id', 'title','body','startDate','endDate','material','tutor');  // Form fields names
        $oldMaterial = $_REQUEST['oldMaterial'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'material':   $newMaterial = basename($_FILES["material"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'title'))).".".pathinfo(basename($_FILES["material"]["name"]),PATHINFO_EXTENSION): ""; 
                                $lessonObj->$postVar = $newMaterial;
                                if($lessonObj->$postVar == "") { $lessonObj->$postVar = $oldMaterial;}
                                $lessonMaterialFil = $newMaterial;
                                break;
                default     :   $lessonObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($lessonObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetMaterial = MEDIA_FILES_PATH."/lesson/". $lessonMaterialFil;
            $uploadOk = 1; $msg = '';
            if($newMaterial !=""){
                if (move_uploaded_file($_FILES["material"]["tmp_name"], $targetMaterial)) {
                    $msg .= "The file ". basename( $_FILES["material"]["name"]). " has been uploaded.";
                    $status = 'ok'; if(file_exists(MEDIA_FILES_PATH."lesson/".$oldMaterial)) unlink(MEDIA_FILES_PATH."lesson/".$oldMaterial); $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
            if($uploadOk == 1){
                echo $lessonObj->update();
            }
            else {
                    $msg = " Sorry, there was an error uploading your lesson material. ERROR: ".$msg;
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