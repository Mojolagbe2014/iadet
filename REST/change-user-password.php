<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Cject of User class
$errorArr = array(); //Array of errors
$newPassword ="";

if(filter_input(INPUT_POST, "LoggedInUserId")!=NULL){
    $postVars = array('oldPassword', 'newPassword', 'confirmPassword'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'confirmPassword':    if(filter_input(INPUT_POST,$postVar) !== filter_input(INPUT_POST, "newPassword")){
                            array_push ($errorArr, "Password Mismatch !!! ");
                            if(filter_input(INPUT_POST, $postVar) == "") {array_push ($errorArr, "Please confirm your password. ");}}
                            break;
            case 'newPassword'     : $newPassword = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($newPassword == "") {array_push ($errorArr, " $postVar ");}
                                if(!(preg_match( '~[A-Z]~', $newPassword) && preg_match( '~[a-z]~', $newPassword) && preg_match( '~\d~', $newPassword) && (strlen( $newPassword) > 7) && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $newPassword))){
                                    array_push ($errorArr, " Password must contain at least 8 characters including at least 1 digit, at least 1 uppercase letter, at least 1 non-alphanumeric character "); 
                                }
                            break;
            case 'oldPassword'     :   $userObj->passWord = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($userObj->passWord == "") {array_push ($errorArr, " Current password ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        //$userObj->passWord = 'testing';//mysqli_real_escape_string($dbMoObj->connection, filter_input(INPUT_POST, 'oldPassword'));
        $userObj->id = filter_input(INPUT_POST, "LoggedInUserId");
        
        echo  $userObj->changePassword($newPassword);
    }
    //Else show error messages
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbMoObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }

}