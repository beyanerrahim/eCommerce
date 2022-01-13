<?php

/*
===================================================
== manage members page
== you can add | edit | delete members from here
===================================================
*/
session_start();
$pageTitle = 'Members page';
if(isset($_SESSION['Username'])){
   
    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page

    if($do == 'Manage'){

        $query = '';
        if(isset($_GET['page']) && $_GET['page']=='pending'){
            $query = 'AND RStatus = 0';
        }
        // select all except admin 
        $stmt=$con->prepare("SELECT * FROM users where GroupID != 1 $query order by UserID DESC");
        $stmt->execute();

        //assaign to varible
        $rows = $stmt->fetchAll();

        if(! empty( $rows)){
    ?>
    <h2 class="text-center">manage Members</h2>
        <div class="container">
            <div class="table-responsive">

            <table class="main-table text-center table table-bordered manage-members">
                <tr>
                    <td>ID</td>
                    <td>image</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Full name</td>
                    <td>Registered Date</td>
                    <td>Control</td>
                </tr>
                <?php 
                foreach($rows as $row){?>
                  <tr>
                    <td><?php echo $row['UserID'];?></td>
                    <td>
                        <?php
                        if(empty($row['avatar'])){
                           echo 'No image';
                        }else{
                        ?>
                        <img src="uploads/avatars/<?php echo $row['avatar'];?>" alt=""/>
                       <?php  }?>
                    </td>
                    <td><?php echo $row['Username'];?></td>
                    <td><?php echo $row['Email'];?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['Date'];?></td>
                    <td>
                        <a href="members.php?do=Edit&userid=<?php echo $row['UserID']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="members.php?do=Delete&userid=<?php echo $row['UserID']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                        <?php
                      if($row['RStatus'] == 0){?>
                     <a href="members.php?do=Activate&userid=<?php echo $row['UserID']?>" class="btn btn-info Activate "><i class="fa fa-check"></i>Activate</a>

                      <?php }
                        ?>
                    </td>
                </tr>                 
                 <?php
                      
                } 
                ?> 
                </table>
            </div>              
        <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
        </div>
  
<?php 
        }
        else{
           echo '<div class="container">';
                echo '<div class="nice-massage alert alert-danger ">There is No Member To Manage</div>';
                echo ' <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>';
           echo '</div>';
        }
    }elseif($do == 'Add'){ 
         // echo 'welcome to Add members page';
        ?>
      
       <h2 class="text-center">Add new  Member</h2>
        <div class="container">
             <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                 <!-- start username field-->
                   <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Username:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="text" name="username" class="form-control"  placeholder="User name" autocomplete="off" required/> 
                       </div>
                  </div>
                   <!-- end username field-->
                   <!-- start password field-->
                   <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Password:</label>
                       <div class="col-sm-10 col-md-4">
                        
                       <input type="password" name="password" class="password form-control" placeholder="password" autocomplete="new-password" required/> 
                      <i class="show-pass fa fa-eye fa-1x"></i>
                    </div>
                   </div>
                   <!-- end password field-->
                    <!-- start Email field-->
                    <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Email:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="email" name="email"  class="form-control" placeholder="Email" required/> 
                       </div>
                   </div>
                   <!-- end Email field-->
                    <!-- start Full name field-->
                    <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Full name:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="text" name="full"  class="form-control" placeholder="full name" required/> 
                       </div>
                   </div>
                   <!-- end Full name field-->
                    <!-- start image field-->
                    <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">User image:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="file" name="avatar"  class="form-control"  required/> 
                       </div>
                   </div>
                   <!-- end image field-->
                    <!-- start save button field-->
                    <div class="form-group form-group-lg">
                       <div class=" col-md-4 col-sm-offset col-sm-10">
                           <input type="submit" value="Add member" class="btn btn-primary "/> 
                       </div>
                   </div>
                   <!-- end save button field-->
             </form>

        </div>
<?php
    }elseif($do =='Insert'){
        //insert member page 

      // echo $_POST['username'] . $_POST['email'] . $_POST['password'] .$_POST['full'] ;
      echo "<h2 class='text-center'>Add Member</h2>";
      echo "<div  class='container'>";

      //upload variables
      //$avatar = $_FILES['avatar'];

      $avatarName=$_FILES['avatar']['name'];
      $avatarSize=$_FILES['avatar']['size'];
      $avatarTmp=$_FILES['avatar']['tmp_name'];
      $avatarType=$_FILES['avatar']['type'];

      //list of allowed file typed to upload
      $avatarAllowedExtension = array("jpeg","jpg","png","gif");

      //get avatar extention
      $avatarExtension = strtolower(end(explode('.',$avatarName)));
     

      if($_SERVER['REQUEST_METHOD'] == 'POST'){

       //Get variables from the form
      
       $user=$_POST['username'];
       $pass=$_POST['password'];
       $email=$_POST['email'];
       $name=$_POST['full'];

       $hashpass = sha1($_POST['password']);

       //validate the form

       $formerrors = array();

       if(strlen($user) < 4){
           $formerrors[] = "user name cant be less than<strong> 4 characters</strong>";
       }
       if(strlen($user) > 20){
           $formerrors[] = 'user name cant be more than<strong> 20 characters</strong>';
       }
       if(empty($user)){
           $formerrors[] = 'user name cant be empty';
       }
       if(empty($pass)){
        $formerrors[] = 'password name cant be empty';
       }
       if(empty($name)){
           $formerrors[] = 'full name cant be empty';
       }
       if(empty($email)){
           $formerrors[] = 'email cant be empty';
       }
       if(!empty($avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)){
        $formerrors[] = 'this extention is not <strong>allowed</strong>';
       }
       if(empty($avatarName)){
        $formerrors[] = 'image is <strong> required</strong>';
       }
       if($avatarSize > 4194304){
        $formerrors[] = 'image can not be largest than <strong>4MB</strong>';
       }
       foreach($formerrors as $error){
           echo "<div class='alert alert-danger'>" . $error ."</div>";
       }


       //check if theres no error proced the update operation 
       if(empty($formerrors)){

          $avatar =rand(0,1000000)."_".$avatarName;
          move_uploaded_file($avatarTmp,"uploads\avatars\\" . $avatar);

        $check = checkItem('Username','users',$user);
        if($check == 1){

            $themsg = "<div class='alert alert-danger'>sorry this user is exist</div>";
            redirectHome($themsg ,'back');

        }else{
       //insert user information in database
       
       $stmt=$con->prepare("INSERT INTO users(Username , Password ,Email ,FullName ,RStatus,Date,avatar) VALUES(:user , :pass,:mail,:name,1,now(),:avatar)" );
       $stmt->execute(array(
           'user' => $user,
           'pass' => $hashpass,
           'mail' => $email,
           'name' => $name,
           'avatar' => $avatar
       ));
       //print seccess massage ;

       $themsg = "<div class='alert alert-success'> ". $stmt->rowCount() . " Record inserted</div>";
       redirectHome($themsg ,'back');
    }
       }
      } else{

        echo "<div class='container'>";
        $themsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
        redirectHome($themsg,'back',3);
        echo "</div>";
      }
      echo "</div>";

    }
    elseif($do == 'Edit'){ //edit page
      // chek if get request userid is numeric & get the integer value of it
      $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) : 0;

    // select all data depend on this ID
      $stmt = $con ->prepare("SELECT * FROM users where UserID = ? limit 1");
      //Execute Query
      $stmt->execute(array($userid));
      //Fetch the data
      $row = $stmt->fetch();
      //the row count
      $count = $stmt->rowCount();
      //if theres such id show the form
      if($stmt->rowCount()> 0 ){
    
    ?>
        <h2 class="text-center">Edit Member</h2>
        <div class="container">
             <form class="form-horizontal" action="?do=Update" method="POST">
                 <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
                 <!-- start username field-->
                   <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Username:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="text" name="username" class="form-control" value="<?php echo $row['Username']; ?>" placeholder="User name" autocomplete="off" required/> 
                       </div>
                   </div>
                   <!-- end username field-->
                   <!-- start password field-->
                   <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Password:</label>
                       <div class="col-sm-10 col-md-4">
                       <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>"/> 

                        <input type="password" name="newpassword" class="form-control" placeholder="leave lank if you dont want to change" autocomplete="new-password"/> 
                       </div>
                   </div>
                   <!-- end password field-->
                    <!-- start Email field-->
                    <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Email:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="email" name="email" value="<?php echo $row['Email']; ?>" class="form-control" placeholder="Email" required/> 
                       </div>
                   </div>
                   <!-- end Email field-->
                    <!-- start Full name field-->
                    <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Full name:</label>
                       <div class="col-sm-10 col-md-4">
                           <input type="text" name="full" value="<?php echo $row['FullName']; ?>" class="form-control" placeholder="full name" required/> 
                       </div>
                   </div>
                   <!-- end Full name field-->
                    <!-- start save button field-->
                    <div class="form-group form-group-lg">
                       <div class=" col-md-4 col-sm-offset col-sm-10">
                           <input type="submit" value="save" class="btn btn-primary "/> 
                       </div>
                   </div>
                   <!-- end save button field-->
             </form>

        </div>


    <?php 
    //if theres no such id show Error Message
    }else{
        echo "<div class='container'>";
        $themsg = '<div class="alert alert-danger">theres no such ID</div>';
        redirectHome($themsg);
        echo "</div>";
    }
    }elseif($do == 'Update'){
       echo "<h2 class='text-center'>Update Member</h2>";
       echo "<div  class='container'>";

       if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Get variables from the form
        $id=$_POST['userid'];
        $user=$_POST['username'];
        $email=$_POST['email'];
        $name=$_POST['full'];

         // password trick
        $pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

        //validate the form

        $formerrors = array();

        if(strlen($user) < 4){
            $formerrors[] = "<div class='alert alert-danger'>user name cant be less than<strong> 4 characters</strong> </div>";
        }
        if(strlen($user) > 20){
            $formerrors[] = '<div class="alert alert-danger">user name cant be more than<strong> 20 characters</strong> </div>';
        }
        if(empty($user)){
            $formerrors[] = '<div class="alert alert-danger">user name cant be empty</div>';
        }
        if(empty($name)){
            $formerrors[] = '<div class="alert alert-danger">full name cant be empty</div>';
        }
        if(empty($email)){
            $formerrors[] = '<div class="alert alert-danger">email cant be empty</div>';
        }
        foreach($formerrors as $error){
            echo $error;
        }
        //check if theres no error proced the update operation 
        if(empty($formerrors)){

         $tmt2 = $con ->prepare("SELECT * FROM users where Username=? and UserID=? ");
         
         $stmt->execute(array($user , $id));
         $count = $stmt2->rowCount();

         if($count == 1){
             echo '<div class="alert alert-danger">sorry this user is exist</div>';
             redirectHome($themsg,'back');
         }
         else{

        //Update the database with this Info
         $stmt=$con->prepare("UPDATE users set Username = ?, Email = ?, FullName = ? , Password =? where UserID != ?");
         $stmt->execute(array($user,$email,$name,$pass,$id));
       

         $themsg = "<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Updated</div>';
         redirectHome($themsg,'back');
         }
       
        }

       }else{
         $errormsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
         redirectHome($errormsg);
           //echo "sorry you cant browser this page directly";
       }
       echo "</div>";
    }elseif($do == 'Delete'){ //Delete member page
        
        echo "<h2 class='text-center'>Delete Member</h2>";
        echo "<div  class='container'>";

       // chek if get request userid is numeric & get the integer value of it
       $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) : 0;

       // select all data depend on this ID
        // $stmt = $con ->prepare("SELECT * FROM users where UserID = ? limit 1");
        $check = checkItem('userid','users',$userid);
         //Execute Query
        // $stmt->execute(array($userid));

         //the row count
         //$count = $stmt->rowCount();

         //if theres such id show the form
         if($check > 0 ){
      
            $stmt = $con->prepare('DELETE FROM users WHERE UserID = :zuser');
            $stmt->bindParam("zuser",$userid);
            $stmt->execute();
            
            $themsg ="<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($themsg,'back');

         }else{
            $themsg ='<div class="alert alert-danger">this id is not Exist</div>';
            redirectHome($themsg);
         }
     echo '</div>';
    }elseif($do == 'Activate'){
        
        echo "<h2 class='text-center'>Activate Member</h2>";
        echo "<div  class='container'>";

       // chek if get request userid is numeric & get the integer value of it
       $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) : 0;

       // select all data depend on this ID
        // $stmt = $con ->prepare("SELECT * FROM users where UserID = ? limit 1");
        $check = checkItem('userid','users',$userid);
         //Execute Query
        // $stmt->execute(array($userid));

         //the row count
         //$count = $stmt->rowCount();

         //if theres such id show the form
         if($check > 0 ){
      
            $stmt = $con->prepare('UPDATE users set RStatus =1 where UserID = ?');
           
            $stmt->execute(array($userid));
            
            $themsg ="<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Activated</div>';
            redirectHome($themsg,'back');

         }else{
            $themsg ='<div class="alert alert-danger">this id is not Exist</div>';
            redirectHome($themsg);
         }
     echo '</div>';

    }


    include $tpl . "footer.php";

}else{  
    header('Location: index.php');
    exit();
}
