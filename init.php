<?php

//Erroes reporting

ini_set('display_errors','On');
error_reporting(E_ALL);

include 'admin/connect.php';

$tpl = "includes/templates/";    //template directory
$lang = 'includes/languages/';
$func = 'includes/functions/';
$css = "layout/css/";           //css directory
$js = "layout/js/";             //js directory


$sessionUser='';
if(isset($_SESSION['user'])){
    
    $sessionUser= $_SESSION['user'];
}

//include the important files

include $func . 'functions.php';
include $lang . 'english.php';
include $tpl . "header.php";

