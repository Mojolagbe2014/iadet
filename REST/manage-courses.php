<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseObj = new Course($dbObj, ''); // Create an object of CourseCategory class
$errorArr = array(); //Array of errors
$oldMedia = ""; $newMedia =""; $oldImage=""; $newImage =""; $courseImageFil="";

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchCourses") != NULL){
        $requestData= $_REQUEST;
        $columns = array( 0 => 'name', 1 => 'amount', 2=> 'promotion_amount');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM course ");
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM course WHERE 1=1 "; //id, name, short_name, category, start_date, code, description, media, amount, date_registered
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( name LIKE '%".$requestData['search']['value']."%' ";    
                $sql.=" OR amount LIKE '%".$requestData['search']['value']."%' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

        echo $courseObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    if(filter_input(INPUT_POST, "updateThisCourse") != NULL && filter_input(INPUT_POST, "updateThisCourse") == 'updateThisCourse'){
        $postVars = array('name','amount', 'promotionAmount'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'promotionAmount'     :   $courseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                default     :   $courseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                if($courseObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            //Course::updateSingle($dbObj, 'promotion_amount', $courseObj->promotionAmount, " name = '$courseObj->name' ");
            //echo Course::updateSingle($dbObj, 'amount', $courseObj->amount, " name = '$courseObj->name' ");
            echo Course::updateSpecial($dbObj, $courseObj->amount, $courseObj->promotionAmount, $courseObj->name);
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
    if(filter_input(INPUT_POST, "updateThisCourse") != NULL && filter_input(INPUT_POST, "updateThisCourse") == 'addCourse'){
        $postVars = array('name2','amount', 'promotionAmount'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'promotionAmount'     :   $courseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                break;
                case 'name2':   $courseObj->name = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                if($courseObj->name == "") {array_push ($errorArr, "Please enter course name ");}
                                break;
                default     :   $courseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, trim(filter_input(INPUT_POST, $postVar))) :  ''; 
                                if($courseObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo  $courseObj->add();
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    }
    if(filter_input(INPUT_POST, "deleteThisCourse")!=NULL){
        $postVars = array('name'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $courseObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($courseObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   { echo $courseObj->delete(); }
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    if(filter_input(INPUT_GET, "activateCourse")!=NULL){
        $postVars = array('name', 'status'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'status':  $courseObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($courseObj->$postVar == 1) {$courseObj->$postVar = 0;} 
                                elseif($courseObj->$postVar == 0) {$courseObj->$postVar = 1;}
//                                if($courseObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $courseObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($courseObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo Course::updateSingle($dbObj, ' status ',  $courseObj->status, " name = '$courseObj->name' "); 
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
