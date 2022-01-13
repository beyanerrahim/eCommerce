<?php
ob_start();  //Output Buffering Start
session_start();
//print_r($_SESSION);
if(isset($_SESSION['Username'])){
    //echo "welcome " . $_SESSION['Username'];
    $pageTitle ='dashboard page';
    include 'init.php';

    /* start dashboard page */  
    $numusers = 5; //number of latest users
    $Latestusers = getLatest('*','users','UserID' ,$numusers);  //latest users Array

    $numitems = 5; //number of latest itemss
    $Latestitems = getLatest('*','items','item_ID' ,$numitems); //latest items Array

    $numcomments = 5; //number of latest comments
    $Latestcomments = getLatest('*','comments','c_id' ,$numcomments); //latest comments gArray


 ?>
 <div class="home-stats" >
  <div class="container text-center" >
      <h2>Dashboard</h2>
         <div class="row">

        <div class="col-md-3">
          
            <div class="stat st-members">
            <i class="fa fa-users"></i>
               <div class="info">
                    Total Members
                   <span><a href="members.php"><?php echo countItems('UserID','users');?></a></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-pending">
            <i class="fa fa-user-plus"></i>
               <div class="info">
                pending Members
                <span><a href="members.php?do=Manage&page=pending"><?php echo checkItem('RStatus','users', 0);?></a></span> 
               </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-items">
            <i class="fa fa-tag"></i>
               <div class="info">
                Total Items
                <span><a href="items.php"><?php echo countItems('item_ID','items');?></a></span>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-comments">
            <i class="fa fa-comments"></i>
               <div class="info">
                Total Comments 
                <span><a href="comments.php"><?php echo countItems('c_id','comments');?></a></span>
               </div>
            </div>
        </div>
        </div>
        </div>
  </div>
  <div class="latest">
  <div class="container">
      <div class="row">
          <div class="col-sm-6">
             <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-users"></i> Latest <?php echo $numusers; ?> Register Users
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                      </span>
                  </div>
                  <div class="panel-body">
                      <ul class="list-unstyled latest-users">
                      <?php
                      if(! empty($Latestusers)){
                        foreach($Latestusers as $user){
                          echo '<li>';
                            echo $user['Username'];
                            echo '<a href="members.php?do=Edit&userid='.$user['UserID'] .'">';
                               echo '<span class="btn btn-success pull-right">';
                                    echo '<i class="fa fa-edit"></i> Edit';
                                    if($user['RStatus'] == 0){
                                      echo "<a href='members.php?do=Activate&userid=".$user['UserID']."' class='btn btn-info pull-right Activate '><i class='fa fa-check'></i>Activate</a>";                   
                                    }
                               echo '</span>';
                            echo '</a>';
                          echo '</li>';
                        
                        }}
                        else{
                          echo 'there is no users to show ';
                        }

                    ?>
                    </ul>
                  </div>
             </div>
        
          </div>
          <div class="col-sm-6">
             <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-tag"></i>Latest <?php echo $numitems; ?> Items
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                      </span>
                  </div>
                  <div class="panel-body">
                  <ul class="list-unstyled latest-users">
                      <?php
                         if(! empty($Latestitems)){
                        foreach($Latestitems as $item){
                          echo '<li>';
                            echo $item['Name'];
                            echo '<a href="items.php?do=Edit&itemid='.$item['item_ID'] .'">';
                               echo '<span class="btn btn-success pull-right">';
                                    echo '<i class="fa fa-edit"></i> Edit';
                                    if($item['Approve'] == 0){
                                      echo "<a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='btn btn-info pull-right Activate '><i class='fa fa-check'></i>Approve</a>";                   
                                    }
                               echo '</span>';
                            echo '</a>';
                          echo '</li>';
                        
                        }}
                        else{
                          echo 'there is no items to show ';
                        }

                    ?>
                    </ul>
                  </div>
             </div>
          </div>
     </div>

     <!-- Start latest Comments -->

     <div class="row">
          <div class="col-sm-6">
             <div class="panel panel-default">
                  <div class="panel-heading">
                      <i class="fa fa-comments-o"></i> Latest <?php echo $numcomments; ?> Comments
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                      </span>
                  </div>
                  <div class="panel-body">
                    <?php

                      $stmt=$con->prepare("SELECT comments.*,users.Username as Member  FROM comments
                      INNER JOIN users ON users.UserID = comments.user_id order by c_id DESC limit $numcomments
                     ");
                     $stmt->execute();
        
                     $comments = $stmt->fetchAll();
                     if(!empty($comments)){
                     foreach($comments as $comment){
                       echo '<div class="comment-box">';
                           echo '<span class="member-n">' . $comment['Member'] . '</span>';
                           echo '<p class="member-c">' . $comment['comment'] . '</p>';
                       echo '</div>';
                     }
                    }
                    else{
                      echo 'there is no Comment to show ';
                    }
                   ?>
                  </div>
             </div>
        
          </div>
          
     </div>
      <!-- End latest Comments -->
     </div>
  </div>
<?php 
   // print_r($_SESSION);
    include $tpl . "footer.php";

}else{  
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>
