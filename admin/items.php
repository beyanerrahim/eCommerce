<?php
ob_start();
session_start();

$pageTitle = 'items';
if (isset($_SESSION['Username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
          
        // select all except admin 
        $stmt = $con->prepare("SELECT items.*,
        categories.Name as category_name,
        users.Username FROM items
        inner join categories on categories.ID = items.Cat_ID
        inner join users on users.UserID = items.Member_ID
        order by item_ID DESC
        ");

        $stmt->execute();

        //assaign to varible
        $items = $stmt->fetchAll();

        if(! empty($items) ){
       
    ?>
    <h2 class="text-center">manage Items</h2>
        <div class="container">
            <div class="table-responsive">

            <table class="main-table text-center table table-bordered">
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Date</td>
                    <td>Ctegory</td>
                    <td>Username</td>
                    <td>Control</td>
                </tr>
                <?php 
                foreach($items as $item){?>
                  <tr>
                    <td><?php echo $item['item_ID'];?></td>
                    <td><?php echo $item['Name'];?></td>
                    <td><?php echo $item['Description'];?></td>
                    <td><?php echo $item['Price'];?></td>
                    <td><?php echo $item['Add_Date'];?></td>
                    <td><?php echo $item['category_name'];?></td>
                    <td><?php echo $item['Username'];?></td>
                    <td>
                        <a href="items.php?do=Edit&itemid=<?php echo $item['item_ID']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="items.php?do=Delete&itemid=<?php echo $item['item_ID']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                    <?php
                      if($item['Approve'] == 0){?>

                            <a href="items.php?do=Approve&itemid=<?php echo $item['item_ID']?>" class="btn btn-info Activate "><i class="fa fa-check"></i>Approve</a>

                      <?php }?>

                    </td>
                </tr>                 
                 <?php
                      
                } 
                ?> 
                </table>
            </div>              
        <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
        </div>

<?php 
        }
        else{
            echo '<div class="container">';
                echo '<div class="nice-massage alert alert-danger ">There is No Member To Manage</div>';
                echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>';
           echo '</div>';
        
        }
    } elseif ($do == 'Add') {
?>
        <h2 class="text-center">Add new Item</h2>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <!-- start name field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Item name" />
                    </div>
                </div>
                <!-- end name field-->
                <!-- start Description field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Description :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Description of the item" />
                    </div>
                </div>
                <!-- end Description field-->
                <!-- start price field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Price :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" placeholder="price of the item"  />
                    </div>
                </div>
                <!-- end price field-->
                <!-- start country field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Country :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="country" class="form-control" placeholder="country of Made"  />
                    </div>
                </div>
                <!-- end country field-->
                <!-- start status field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="status" id="">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very old</option>
                        </select>
                    </div>
                </div>
                <!-- end status field-->
                <!-- start members field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Member :</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="member" id="">
                        <option value="0">...</option>
                            <?php
                            $allmembers = getAllFrom("*","users","","","UserID");
                            //  $stmt=$con->prepare("SELECT * FROM users");
                            //  $stmt->execute();
                            //  $users=$stmt->fetchAll();
                             foreach($allmembers as $user){
                                 echo "<option value='". $user['UserID']."'>".$user['Username'] ."</option>";
                             }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end mrmbers field-->
                 <!-- start categories field-->
                 <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Category :</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="category" id="">
                        <option value="0">...</option>
                            <?php
                             $allcats = getAllFrom("*","categories","WHERE parent =0","","ID");
                            //  $stmt1=$con->prepare("SELECT * FROM categories");
                            //  $stmt1->execute();
                            //  $cats=$stmt1->fetchAll();
                             foreach($allcats as $cat){
                                 echo "<option value='". $cat['ID']."'>".$cat['Name'] ."</option>";
                                 $childcats = getAllFrom("*","categories","WHERE parent ={$cat['ID']}","","ID");
                                 foreach($childcats as $child){
                                    echo "<option value='". $child['ID']."'>".$child['Name'] ." ".$cat['Name']."</option>";
                                 }
                             }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end categories field-->

                 <!-- start tags field-->
                 <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Tags :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="tags" class="form-control" placeholder="separate tags with comma(,)"  />
                    </div>
                </div>
                <!-- end tags field-->

                <!-- start add button field-->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                    </div>
                </div>
                <!-- end add button field-->
            </form>

        </div>


<?php

    } elseif ($do == 'Insert') {

        echo "<h2 class='text-center'>Insert Item</h2>";
        echo "<div  class='container'>";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get variables from the form

            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $cat = $_POST['category'];
            $tags = $_POST['tags'];
            //validate the form

            $formerrors = array();

            if (empty($name) ) {
                $formerrors[] = "Name can not be <strong> Empty</strong>";
            }
            if (empty($desc)) {
                $formerrors[] = 'Description can not be <strong> Empty</strong>';
            }
            if (empty($price)) {
                $formerrors[] = 'The Price can not be <strong> Empty</strong>';
            }
            if (empty($country)) {
                $formerrors[] = 'the Country not be <strong> Empty</strong>';
            }
            if ($status==0) {
                $formerrors[] = 'You Most Choose the <strong>Status </strong>';
            }
            if ($member==0) {
                $formerrors[] = 'You Most Choose the <strong>Member </strong>';
            }
            if ($cat==0) {
                $formerrors[] = 'You Most Choose the <strong>Category </strong>';
            }
            foreach ($formerrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }


            //check if theres no error proced the update operation 
            if (empty($formerrors)) {

                    //insert user information in database

                    $stmt = $con->prepare("INSERT INTO items(Name , Description ,Price ,Country_Made ,Status,Add_Date,Cat_ID,Member_ID,tags) VALUES(:name , :desc,:price,:country,:status,now(),:cat,:member,:tags)");
                    $stmt->execute(array(
                        'name' => $name,
                        'desc' => $desc,
                        'price' => $price,
                        'country' => $country,
                        'status' => $status,
                        'cat' => $cat,
                        'member' => $member,
                        'tags' => $tags
                    ));
                    //print seccess massage ;

                    $themsg = "<div class='alert alert-success'> " . $stmt->rowCount() . " Record inserted</div>";
                    redirectHome($themsg, 'back');
               
            }
        } else {

            echo "<div class='container'>";
            $themsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
            redirectHome($themsg);
            echo "</div>";
        }
        echo "</div>";
    } elseif ($do == 'Edit') {
           // chek if get request itemid is numeric & get the integer value of it
      $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?  intval($_GET['itemid']) : 0;

      // select all data depend on this ID
        $stmt = $con ->prepare("SELECT * FROM items where item_ID = ?");
        //Execute Query
        $stmt->execute(array($itemid));
        //Fetch the data
        $item = $stmt->fetch();
        //the row count
        $count = $stmt->rowCount();
        //if theres such id show the form
        if($stmt->rowCount()> 0 ){?>
             <h2 class="text-center">Edit Item</h2>
            <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>
                <!-- start name field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Item name" value="<?php echo $item['Name']?>"/>
                    </div>
                </div>
                <!-- end name field-->
                <!-- start Description field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Description :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Description of the item" value="<?php echo $item['Description']?>" />
                    </div>
                </div>
                <!-- end Description field-->
                <!-- start price field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Price :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" placeholder="price of the item"  value="<?php echo $item['Price']?>"/>
                    </div>
                </div>
                <!-- end price field-->
                <!-- start country field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Country :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="country" class="form-control" placeholder="country of Made" value="<?php echo $item['Country_Made']?>" />
                    </div>
                </div>
                <!-- end country field-->
                <!-- start status field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="status" id="">
                            
                            <option value="1" <?php if($item['Status']== 1){echo 'selected';}?>>New</option>
                            <option value="2" <?php if($item['Status']== 2){echo 'selected';}?>>Like New</option>
                            <option value="3" <?php if($item['Status']== 3){echo 'selected';}?>>Used</option>
                            <option value="4" <?php if($item['Status']== 4){echo 'selected';}?>>Very old</option>
                        </select>
                    </div>
                </div>
                <!-- end status field-->
                <!-- start members field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Member :</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="member" id="">
                        
                            <?php
                             $stmt=$con->prepare("SELECT * FROM users");
                             $stmt->execute();
                             $users=$stmt->fetchAll();
                             foreach($users as $user){
                                 echo "<option value='". $user['UserID']."'";
                                 if($item['Member_ID'] == $user['UserID'] ){echo 'selected';}
                                 echo ">".$user['Username'] ."</option>";
                             }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end mrmbers field-->
                 <!-- start categories field-->
                 <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Category :</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="category" id="">
                        
                            <?php
                             $stmt1=$con->prepare("SELECT * FROM categories");
                             $stmt1->execute();
                             $cats=$stmt1->fetchAll();
                             foreach($cats as $cat){
                                 echo "<option value='". $cat['ID']."'";
                                 if($item['Cat_ID'] == $cat['ID'] ){echo 'selected';}
                                 echo ">".$cat['Name'] ."</option>";
                             }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end categories field-->
                <!-- start tags field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Tags :</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="tags" class="form-control" placeholder="separate tags with comma(,)" 
                        value="<?php echo $item['tags']?>" />
                    </div>
                </div>
                <!-- end tags field-->
                <!-- start add button field-->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
                    </div>
                </div>
                <!-- end add button field-->
            </form>
<?php
            // select all except admin 
        $stmt=$con->prepare("SELECT comments.*,users.Username as Member  FROM comments
         INNER JOIN users ON users.UserID = comments.user_id where item_id = ?
        ");
        $stmt->execute(array($itemid));

        //assaign to varible
        $rows = $stmt->fetchAll();

        if(!empty($rows)){
    ?>
    <h2 class="text-center">manage [<?php echo $item['Name']; ?>] Comments</h2>
            <div class="table-responsive">

            <table class="main-table text-center table table-bordered">
                <tr>
                    <td>comment</td>
                    <td>User Name</td>
                    <td>Added Date</td>
                    <td>Control</td>
                </tr>
                <?php 
                foreach($rows as $row){?>
                  <tr>
                    <td><?php echo $row['comment'];?></td>
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
           <?php }?>
        </div>

          
      <?php 
      //if theres no such id show Error Message
      }else{
          echo "<div class='container'>";
          $themsg = '<div class="alert alert-danger">theres no such ID</div>';
          redirectHome($themsg);
          echo "</div>";
      }


    } elseif ($do == 'Update') {
        echo "<h2 class='text-center'>Update Item</h2>";
        echo "<div  class='container'>";

       if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Get variables from the form
        $id=$_POST['itemid'];
        $name=$_POST['name'];
        $desc=$_POST['description'];
        $price=$_POST['price'];
        $country=$_POST['country'];

        $status=$_POST['country'];
        $member=$_POST['member'];
        $category=$_POST['category'];
        $tags=$_POST['tags'];
        //validate the form

        $formerrors = array();

            if (empty($name) ) {
                $formerrors[] = "Name can not be <strong> Empty</strong>";
            }
            if (empty($desc)) {
                $formerrors[] = 'Description can not be <strong> Empty</strong>';
            }
            if (empty($price)) {
                $formerrors[] = 'The Price can not be <strong> Empty</strong>';
            }
            if (empty($country)) {
                $formerrors[] = 'the Country not be <strong> Empty</strong>';
            }
            if ($status==0) {
                $formerrors[] = 'You Most Choose the <strong>Status </strong>';
            }
            if ($member==0) {
                $formerrors[] = 'You Most Choose the <strong>Member </strong>';
            }
            if ($category==0) {
                $formerrors[] = 'You Most Choose the <strong>Category </strong>';
            }
            foreach ($formerrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }

        //check if theres no error proced the update operation 
        if(empty($formerrors)){
        //Update the database with this Info
        $stmt=$con->prepare("UPDATE items set
         Name = ?, Description = ?, Price = ? , Country_Made =?, Status =?,Cat_ID =? ,Member_ID =?,tags=? where item_ID = ?");


        $stmt->execute(array($name,$desc,$price,$country,$status,$category ,$member,$tags,$id));
        //print seccess massage ;

       $themsg = "<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Updated</div>';
        redirectHome($themsg,'back');
        }

       }else{
         $errormsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
         redirectHome($errormsg);
           //echo "sorry you cant browser this page directly";
       }
       echo "</div>";
    } elseif ($do == 'Delete') {
        echo "<h2 class='text-center'>Delete Item</h2>";
        echo "<div  class='container'>";

       // chek if get request itemid is numeric & get the integer value of it
       $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?  intval($_GET['itemid']) : 0;

       // select all data depend on this ID
        $check = checkItem('item_ID','items',$itemid);

         //if theres such id show the form
         if($check > 0 ){
      
            $stmt = $con->prepare('DELETE FROM items WHERE item_ID = :zid');
            $stmt->bindParam("zid",$itemid);
            $stmt->execute();
            
            $themsg ="<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($themsg,'back');

         }else{
            $themsg ='<div class="alert alert-danger">this id is not Exist</div>';
            redirectHome($themsg);
         }
     echo '</div>';
    } elseif ($do == 'Approve') {

        echo "<h2 class='text-center'>Approve item</h2>";
        echo "<div  class='container'>";

       // chek if get request itemid is numeric & get the integer value of it
       $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?  intval($_GET['itemid']) : 0;

       // select all data depend on this ID
        $check = checkItem('item_ID','items',$itemid);
        
         //if theres such id show the form
         if($check > 0 ){
      
            $stmt = $con->prepare('UPDATE items set Approve =1 where item_ID = ?');
           
            $stmt->execute(array($itemid));
            
            $themsg ="<div class='alert alert-success'> ". $stmt->rowCount() . ' Record Approved</div>';
            redirectHome($themsg,'back');

         }else{
            $themsg ='<div class="alert alert-danger">this id is not Exist</div>';
            redirectHome($themsg);
         }
     echo '</div>';

    }

    include $tpl . 'footer.php';
} else {

    header('Location:index.php');
    exit();
}

ob_end_flush();

?>