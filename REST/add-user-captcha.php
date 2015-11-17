<?php
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Create an object of User class
$errorArr = array(); //Array of errors

//$captcha = filter_input(INPUT_POST, 'g-recaptcha-response') ? filter_input(INPUT_POST, 'g-recaptcha-response') : "";
//$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ld_MQ0TAAAAAAY0XqY4Bo1-EE-AKoPXS75ttok-&response=".$captcha));
//if($response->success == true) {
if(filter_input(INPUT_POST, "robot", FILTER_VALIDATE_INT) == 5) {
    $postVars = array('firstName', 'lastName', 'email','userName', 'phone','address','passWord', 'passWord1'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'passWord1':   if(filter_input(INPUT_POST,$postVar) !== filter_input(INPUT_POST, "passWord")){
                                array_push ($errorArr, "Password Mismatch !!! ");
                                if(filter_input(INPUT_POST, $postVar) == "") {array_push ($errorArr, " confirm your password. ");}}
                                break;
            case 'passWord'     :   $userObj->passWord = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userObj->passWord == "") {array_push ($errorArr, " $postVar ");}
                            if(!(preg_match( '~[A-Z]~', $userObj->passWord) && preg_match( '~[a-z]~', $userObj->passWord) && preg_match( '~\d~', $userObj->passWord) && (strlen( $userObj->passWord) > 7) && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $userObj->passWord))){
                                array_push ($errorArr, " Password must contain at least 8 characters including at least 1 digit, at least 1 uppercase letter, at least 1 non-alphanumeric character "); 
                            }
                            break;
            case 'email':   $userObj->$postVar = filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL)) :  ''; 
                            if($userObj->$postVar === "") {array_push ($errorArr, " valid $postVar ");}
                            break;
            default     :   $userObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   { echo $userObj->add(); }
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }
} else{
    $json = array("status" => 0, "msg" => "Prove that you are not a robot"); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
}