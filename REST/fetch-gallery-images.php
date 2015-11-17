<?php
session_start();
define("CONST_FILE_PATH", "../includes/constants.php");
include ('../classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

if(!isset($_SESSION['IADETLoggedInAdmin']) || !isset($_SESSION["IADETadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    echo json_encode($json);
}
else{
    $handle = opendir(dirname(dirname(__FILE__)).'/media/gallery/');
    while($file = readdir($handle)){
        if($file !== '.' && $file !== '..'){
            $filenameArray[] =  array(utf8_encode('<img style="width:40%; height:20%;" src="../media/gallery/'.$file.'">'), utf8_encode(strtoupper($file)), utf8_encode('<button data-image="'.$file.'" class="btn btn-danger btn-small delete-image" title="Delete"> <i class="btn-icon-only icon-trash"></i> </button>'));
        }
    }

    $json = array("status" => 1, "data" => $filenameArray);
    header('Content-type: application/json');
    echo json_encode($json);
}