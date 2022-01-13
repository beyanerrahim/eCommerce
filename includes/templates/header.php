<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
   <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
   <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
   <link rel="stylesheet" href="<?php echo $css; ?>m.css">
   <link rel="stylesheet" href="<?php echo $css; ?>xx.css">

   <link rel="stylesheet" href="<?php echo $css; ?>s.css">
   <link rel="stylesheet" href="<?php echo $css; ?>style.css">
    <title><?php echo getTitle() ;?></title>
</head>
<body>
  <div class="upper-bar">
     <div class="container">

       <?php 
         if(isset($_SESSION['user'])){?>
          <img class="my-img rounded-circle" src="layout/images/images.png" alt="" >
         <div class="btn-group my-info">
        
            <span class="btn dropdown-toggle" data-toggle="dropdown"><?php echo $sessionUser;?>         
            <span class="caret"> </span>         
            </span>
            
            <ul class="dropdown-menu">
                 <li><a href="profile.php">My Profile</a></li>
                 <li><a href="newad.php">New Item</a></li>
                 <li><a href="profile.php#my-ads">my ads</a></li>
                 <li><a href="logout.php">Logout</a></li>
            </ul>
         </div>
 <!-- <div class="dropdown">
  <button type="button" class="btn btn-dark"></button>
  <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="profile.php">My Profile</a>
    <a class="dropdown-item" href="newad.php">New Item</a>
    <a class="dropdown-item" href="logout.php">Logout</a>
   
  </div>
</div> -->
         <?php

          echo 'welcome '.$sessionUser . ' ';
         
          echo '<a href="profile.php">My Profile</a>';
          echo ' - <a href="newad.php">New Item</a>';
          echo ' - <a href="profile.php#my-ads">My Ads</a>';
          echo ' - <a href="logout.php">Logout</a>';
          $userstatus = checkUserstatus($sessionUser);

          if($userstatus == 1){

            echo 'your Membership need to Activate by admin';
             
          }

        }else{
       
       ?>

          <a href="login.php">
                <span class="">Login/Signup</span>
          </a>
          <?php }?>
     </div>
  </div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
  <a class="navbar-brand link-h" href="index.php">Home </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-5 ul-main">
      
    <?php
           $all = getAllFrom("*","categories","where parent = 0","","ID","ASC");
           foreach($all as $cat){
               echo 
               '<li class="ml-3 links-h">
                        <a href="categories.php?pageid='.$cat['ID'].'&pagename=' .str_replace(' ','-',$cat['Name']).'">'. $cat['Name']. '</a>
               </li>';
           }


    ?>
    
    </ul>
  
  </div>
  </div>
</nav>







