<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$categoryObj = new CourseCategory($dbObj, ''); // Create an object of CategoryCategory class
$errorArr = array(); //Array of errors
$oldImage=""; $newImage =""; $catImageFil="";

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchCategories") != NULL){
        $requestData= $_REQUEST;
        $columns = array( 0 => 'name', 1 => 'image', 2 => 'amount', 3 => 'promotion_amount');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM course_categories ");
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM course_categories WHERE 1=1 "; //id, name, short_name, category, start_date, code, description, media, amount, date_registered
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( name LIKE '%".$requestData['search']['value']."%' ";    
                $sql.=" OR amount LIKE '%".$requestData['search']['value']."%' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

        echo $categoryObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    if(filter_input(INPUT_POST, "updateThisCategory") != NULL && filter_input(INPUT_POST, "updateThisCategory") == 'updateThisCategory'){
        $postVars = array('name','amount', 'promotionAmount', 'image', 'firstInstallment', 'otherInstallment'); // Form fields names
        $oldImage = $_REQUEST['oldImage'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'image':   $newImage = basename($_FILES["image"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'name'))).".".pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION): ""; 
                                $categoryObj->$postVar = $newImage;
                                if($categoryObj->$postVar == "") { $categoryObj->$postVar = $oldImage;}
                                break;
                case 'promotionAmount'     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                case 'firstInstallment'     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                case 'otherInstallment'     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                default     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                if($categoryObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetImage = MEDIA_FILES_PATH."category/". $newImage;
            $uploadOk = 1; $msg = '';
            if($newImage !=""){
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetImage)) {
                    $msg .= "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                    $status = 'ok';
                    if($oldImage !='' && file_exists(MEDIA_FILES_PATH."category/".$oldImage)) unlink(MEDIA_FILES_PATH."category/".$oldImage);
                    echo CourseCategory::updateSpecial($dbObj, $categoryObj->amount, $categoryObj->promotionAmount, $categoryObj->image, $categoryObj->firstInstallment, $categoryObj->otherInstallment, $categoryObj->name);
                } else {
                    $msg = " Sorry, there was an error uploading your course media. ERROR: ".$msg;
                    $json = array("status" => 0, "msg" => $msg); 
                    $dbObj->close();//Close Database Connection
                    header('Content-type: application/json');
                    echo json_encode($json);
                }
            } 
            else{
                echo CourseCategory::updateSpecial($dbObj, $categoryObj->amount, $categoryObj->promotionAmount, $categoryObj->image, $categoryObj->firstInstallment, $categoryObj->otherInstallment, $categoryObj->name);
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
    if(filter_input(INPUT_POST, "updateThisCategory") != NULL && filter_input(INPUT_POST, "updateThisCategory") == 'addCategory'){
        $postVars = array('name2','amount', 'promotionAmount', 'image', 'firstInstallment', 'otherInstallment'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'promotionAmount'     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                case 'name2':   $categoryObj->name = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                if($categoryObj->name == "") {array_push ($errorArr, "Please enter course name ");}
                                break;
                case 'image':   $categoryObj->$postVar = basename($_FILES["image"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'name2'))).".".pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION): ""; 
                                $catImageFil = $categoryObj->$postVar;
                                if($categoryObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                case 'firstInstallment'     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                case 'otherInstallment'     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                default     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                if($categoryObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetImage = MEDIA_FILES_PATH."/category/". $catImageFil;
            $uploadOk = 1; $msg = '';
            if (file_exists($targetImage)) { $msg .= " Course category image already exists."; $uploadOk = 0; }
            if ($_FILES["image"]["size"] > 800000000) { $msg .= " Course category image is too large."; $uploadOk = 0; }
            if ($uploadOk == 0) {
                $msg = "Sorry, your course category image was not uploaded. ERROR: ".$msg;
                $json = array("status" => 0, "msg" => $msg); 
                $dbObj->close();//Close Database Connection
                header('Content-type: application/json');
                echo json_encode($json);
            } 
            else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetImage)) {
                    $msg .= "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                    $status = 'ok';
                    echo $categoryObj->add();
                } else {
                    $msg = " Sorry, there was an error uploading your course category image. ERROR: ".$msg;
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
    if(filter_input(INPUT_POST, "deleteThisCategory")!=NULL){
        $postVars = array('name'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $categoryObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($categoryObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   { echo $categoryObj->delete(); }
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    if(filter_input(INPUT_GET, "activateCategory")!=NULL){
        $postVars = array('name', 'status'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'status':  $categoryObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($categoryObj->$postVar == 1) {$categoryObj->$postVar = 0;} 
                                elseif($categoryObj->$postVar == 0) {$categoryObj->$postVar = 1;}
//                                if($categoryObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $categoryObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($categoryObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo CourseCategory::updateSingle($dbObj, ' status ',  $categoryObj->status, " name = '$categoryObj->name' "); 
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    if(filter_input(INPUT_GET, "activateInstallment")!=NULL){
        $postVars = array('name', 'installment'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'installment':  $categoryObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($categoryObj->$postVar == 1) {$categoryObj->$postVar = 0;} 
                                elseif($categoryObj->$postVar == 0) {$categoryObj->$postVar = 1;}
                                break;
                default     :   $categoryObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($categoryObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo CourseCategory::updateSingle($dbObj, ' installment ',  $categoryObj->installment, " name = '$categoryObj->name' "); 
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
