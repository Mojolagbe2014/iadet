<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$userObj = new User($dbObj); // Create an object of User class
$errorArr = array(); //Array of errors
$oldMedia = ""; $newMedia ="";

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchUsers") != NULL){
        $requestData= $_REQUEST;
        $columns = array(0 => 'id', 1 =>  'name', 2 =>  'email', 3 => 'city', 4 =>  'country', 5 =>  'description', 6 =>  'picture', 7 =>  'website', 8 =>  'skype_id', 9 => 'yahoo_id', 10 =>  'phone', 11 =>  'address', 12 =>  'username', 13 =>  'date_registered', 14 => 'status', 15 => 'facebook_id', 16 => 'twitter_id');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM user ");
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM user WHERE 1=1 "; //id, name, short_name, category, start_date, code, description, media, amount, date_registered
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( name LIKE '%".$requestData['search']['value']."%' ";    
                $sql.=" OR username LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR description LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR email LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR country LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR date_registered LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR phone LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR website LIKE '%".$requestData['search']['value']."%' ";
                $sql.=" OR city LIKE '%".$requestData['search']['value']."%' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

        echo $userObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    
    if(filter_input(INPUT_POST, "deleteThisUser")!=NULL){
        $postVars = array('id', 'picture'); // Form fields names
        $userMedia = "";
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'picture': $userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                $userMedia = $userObj->$postVar;
                                if($userObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($userObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1 && $userMedia != "")   {
            if(unlink(MEDIA_FILES_PATH."user/".$userMedia)){ echo $userObj->delete(); }
            else{ 
                $json = array("status" => 0, "msg" => $errorArr); 
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
    
    if(filter_input(INPUT_GET, "activateUser")!=NULL){
        $postVars = array('id', 'status'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'status':  $userObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($userObj->$postVar == 1) {$userObj->$postVar = 0;} 
                                elseif($userObj->$postVar == 0) {$userObj->$postVar = 1;}
                                break;
                default     :   $userObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($userObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo User::updateSingle($dbObj, ' status ',  $userObj->status, $userObj->id); 
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    
    if(filter_input(INPUT_POST, "updateThisUser") != NULL){
        $postVars = array('id','name','email','city','country','description','picture','website','skypeId','yahooId','phone','address','userName','dateRegistered','facebookId','twitterId'); // Form fields names
        $oldMedia = $_REQUEST['oldFile'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'picture':   $newMedia = basename($_FILES["file"]["name"]) ? rand(100000, 1000000)."_".  strtolower(str_replace(" ", "_", filter_input(INPUT_POST, 'code'))).".".pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION): ""; 
                                $userObj->$postVar = $newMedia;
                                if($userObj->$postVar == "") { $userObj->$postVar = $oldMedia;}
                                $userMedFil = $newMedia;
                                break;
                default     :   $userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($userObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            //$target_dir = "../project-files/";
            $target_file = MEDIA_FILES_PATH."/user/". $userMedFil;
            $uploadOk = 1; $msg = '';
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
           
            if($newMedia !=""){
                if (move_uploaded_file($_FILES["file"]["tmp_name"], MEDIA_FILES_PATH."/user/".$userMedFil)) {
                    $msg .= "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
                    $status = 'ok';
                    unlink(MEDIA_FILES_PATH."user/".$oldMedia);
                    echo $userObj->update();
                } else {
                    $msg = " Sorry, there was an error uploading your user media. ERROR: ".$msg;
                    $json = array("status" => 0, "msg" => $msg); 
                    $dbObj->close();//Close Database Connection
                    header('Content-type: application/json');
                    echo json_encode($json);
                }
            } 
            else{
                echo $userObj->update();
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