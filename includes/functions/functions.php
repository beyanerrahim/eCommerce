<?php
/*
Get all function v2.0
functon to get all records from any database table
*/

function getAllFrom($field ,$table ,$where ,$and ,$orderfield , $ordering="DESC"){
    global $con;

    $getall = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

    $getall->execute();
    $all = $getall->fetchAll();

    return  $all;
}

/*
Get Categories function v1.0
functon to get Categories from database

*/

function getCat(){
    global $con;

    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC  ");
    $getCat->execute();
    $Cats = $getCat->fetchAll();

    return  $Cats;
}

/*

Get  items function v1.0
functon to get items from database

*/

function getItems($where ,$value, $approve=NULL){
    global $con;

    if($approve == NULL){
         $sql ='AND Approve = 1';
    }else{
        $sql = NUll;
    }

    $getItems = $con->prepare("SELECT * FROM items where $where=? $sql ORDER BY item_ID DESC");
    $getItems->execute(array($value));
    $items = $getItems->fetchAll();

    return  $items;
}



/* 
    title function that echo the page title in case the page
    has the variable $pageTitle and echo default for other pages
*/ 

function getTitle(){

    global $pageTitle;
    if(isset($pageTitle)){

        echo $pageTitle;
    }
    else{
        echo 'Default';
    }
}

/*
 Home redirect function v1
 [ this function Accept Parameters ]
 $errorMsg = Echo the error Message
 $url=the link you wantt to direct to
 $seconds = seconds Before redirecting
*/

function redirectHome($errormsg ,$url = null ,$seconds = 3){

    if($url == null){

     $url= 'index.php';
     $link ='Home Page';

    }else{

        $url = isset($_SERVER['HTTP_REFERER'] )&& $_SERVER['HTTP_REFERER'] !=='' ? $_SERVER['HTTP_REFERER'] : 'dashboard.php';
        $link ='Previous Page';
    }
     echo  $errormsg ;

     echo "<div class='alert alert-info'>you will be redirected to $link after $seconds seconds </div>";

     header("refresh: $seconds;url=$url");

     exit();
}

/*
check item function 
function to check item in database [ function accept parameters ]
$select = the item to select [ example : user ,item ,category]
$from = the table to select from [example : users ,items , categorys]
$value = the value of select[example : osama ,box,selectronics]
*/

function checkItem($select , $from ,$value){
    global $con;

    $statment = $con->prepare("SELECT $select From $from where $select= ?"); 
    $statment->execute(array($value));
    $count = $statment->rowCount();

    return $count;

}

/*
count number of items function v1
function to count number of items rows
$item = the Item to count
$table = the table to choose from
*/
function countItems($item , $table){

    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) From $table");
    $stmt2->execute();
    $count = $stmt2->fetchColumn();

    return  $count;
}


/*

Get lates Records function v1.0
functon to get items from database [users , Items , Comments]
$select = field to select 
$table = the table  to choose from
$limit = number of records to get
*/

function getLatest($select ,$table ,$order,$limit = 5){
    global $con;

    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order desc LIMIT $limit ");
    $getstmt->execute();
    $rows = $getstmt->fetchAll();

    return  $rows;
}

/*
check if user is not activated
function to check the regstatus of the user
*/
function checkUserstatus($user){

    global $con;
   $stmtx = $con ->prepare("SELECT Username,RStatus FROM users where Username = ? and RStatus = 0 ");
   $stmtx->execute(array($user));
  
   $status = $stmtx->rowCount();
   return $status;
}












