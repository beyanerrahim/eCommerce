<?php
//routes
include 'connect.php';

$tpl = "includes/templates/";  //template directory
$lang = 'includes/languages/';
$func = 'includes/functions/';
$css = "layout/css/";  //css directory
$js = "layout/js/";    //js directory
//include the important files

include $func . 'functions.php';

include $lang . 'english.php';
include $tpl . "header.php";
//include Navbar on all pages expect the one with $nonavbar variable
if(!isset($nonavbar))
    include $tpl . "navbar.php";

