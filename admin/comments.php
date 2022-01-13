<?php

/*
===================================================
== manage comments page
== you can edit | delete |Approve comments from here
===================================================
*/
session_start();
$pageTitle = 'Comments';
if(isset($_SESSION['Username'])){
   
    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if($do == 'Manage'){

    
        // select all except admin 
        $stmt=$con->prepare("SELECT comments.*,items.Name as Item_Name ,users.Username as Member  FROM comments
         INNER JOIN items ON items.item_ID = comments.item_id
         INNER JOIN users ON users.UserID = comments.user_id
         order by c_id DESC
        ");
        $stmt->execute();

        //assaign to varible
        $rows = $stmt->fetchAll();
        if(!empty($rows)){
    ?>
    <h2 class="text-center">manage Comments</h2>
        <div class="container">
            <div class="table-responsive">

            <table class="main-table text-center table table-bordered">
                <tr>
                    <td>ID</td>
                    <td>comment</td>
                    <td>Item Name</td>
                    <td>User Name</td>
                    <td>Added Date</td>
                    <td>Control</td>
                </tr>
                <?php 
                foreach($rows as $row){?>
                  <tr>
                    <td><?php echo $row['c_id'];?></td>
                    <td><?php echo $row['comment'];?></td>
                    <td><?php echo $row['Item_Name'];?></td>
                    <td><?php echo $row['Member'];?></td>
                    <td><?php echo $row['comment_date'];?></td>
                    <td>
                        <a href="comments.php?do=Edit&comid=<?php echo $row['c_id']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="comments.php?do=Delete&comid=<?php echo $row['c_id']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                        <?php
                      if($row['status'] == 0){?>
                     <a href="comments.php?do=Approve&comid=<?php echo $row['c_id']?>" class="btn btn-info Activate "><i class="fa fa-check"></i>Approve</a>

                      <?php }
                        ?>
                    </td>
                </tr>                 
                 <?php
                      
                } 
                ?> 
                </table>
            </div>              
        </div>

<?php 
        }else{
            echo '<div class="container">';
            echo '<div class="nice-massage alert alert-danger ">There is No comments To show</div>';

            echo '</div>';
        }
    }elseif($do == 'Edit'){ //edit page

      // chek if get request comid is numeric & get the integer value of it
      $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ?  intval($_GET['comid']) : 0;

    // select all data depend on this ID
      $stmt = $con ->prepare("SELECT * FROM comments where c_id = ? ");
      //Execute Query
      $stmt->execute(array($comid));
      //Fetch the data
      $row = $stmt->fetch();
      //the row count
      $count = $stmt->rowCount();
      //if theres such id show the form
      if($stmt->rowCount()> 0 ){
    
    ?>
        <h2 class="text-center">Edit Comment</h2>
        <div class="container">
             <form class="form-horizontal" action="?do=Update" method="POST">
                 <input type="hidden" name="comid" value="<?php echo $comid ?>"/>
                 <!-- start comment field-->
                   <div class="form-group row form-group-lg">
                       <label class="col-sm-2 control-label">Comment :</label>
                       <div class="col-sm-10 col-md-4">
                           <textarea class="form-control" name="comment" ><?php echo $row['comment'] ?></textarea>
                       </div>
                   </div>
                   <!-- end comment field--> 
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
       echo "<h2 class='text-center'>Update Comment</h2>";
       echo "<div  class='container'>";

       if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Get variables from the form
        $comid=$_POST['comid'];
        $comment=$_POST['comment'];
      

     
        //Update the database with this Info
        $stmt=$con->prepare("UPDATE comments set comment = ? where c_id = ?");
        $stmt->execute(array($comment,$comid));
        //print seccess massage ;

       $themsg = "<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Updated</div>';
        redirectHome($themsg,'back');

       }else{
         $errormsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
         redirectHome($errormsg);
           //echo "sorry you cant browser this page directly";
       }
       echo "</div>";
    }elseif($do == 'Delete'){ //Delete member page
        
        echo "<h2 class='text-center'>Delete comment</h2>";
        echo "<div  class='container'>";

       // chek if get request comid is numeric & get the integer value of it
       $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ?  intval($_GET['comid']) : 0;

       // select all data depend on this ID
        $check = checkItem('c_id','comments',$comid);
        
         //if theres such id show the form
         if($check > 0 ){
      
            $stmt = $con->prepare('DELETE FROM comments WHERE c_id = :zid');
            $stmt->bindParam("zid",$comid);
            $stmt->execute();
            
            $themsg ="<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($themsg,'back');

         }else{
            $themsg ='<div class="alert alert-danger">this id is not Exist</div>';
            redirectHome($themsg);
         }
     echo '</div>';
    }elseif($do == 'Approve'){
        
        echo "<h2 class='text-center'>Approve Comment</h2>";
        echo "<div  class='container'>";

       // chek if get request userid is numeric & get the integer value of it
       $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ?  intval($_GET['comid']) : 0;

       // select all data depend on this ID
       
        $check = checkItem('c_id','comments',$comid);
    

         //if theres such id show the form
         if($check > 0 ){
      
            $stmt = $con->prepare('UPDATE comments set status = 1 where c_id = ?');
           
            $stmt->execute(array($comid));
            
            $themsg ="<div class='alert alert-success'> ". $stmt->rowCount() . ' Comment Approved</div>';
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
