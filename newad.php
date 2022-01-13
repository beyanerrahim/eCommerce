<?php
session_start();
$pageTitle = 'Create New Item';
include "init.php";

if (isset($_SESSION['user'])) {

    if($_SERVER['REQUEST_METHOD']=='POST'){
        
       $formErrors = array();

       $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
       $desc = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
       $price = filter_var($_POST['price'] ,FILTER_SANITIZE_NUMBER_INT);
       $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
       $status =filter_var( $_POST['status'],FILTER_SANITIZE_NUMBER_INT);
       $category = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
       $tags = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);


       if(strlen($name) < 3){
          $formErrors[]='Item Title Must Be At Least 4 Characters';
       }
       if(strlen($desc) < 10){
        $formErrors[]='Item Description Must Be At Least 10 Characters';
        }
     if(strlen($country) < 2){
        $formErrors[]='Item Country Must Be At Least 2 Characters';
        }
        if(empty($price)){
            $formErrors[]='Item Price Must Be Not Empty';
        }
        if(empty($status)){
            $formErrors[]='Item Status Must Be Not Empty';
        }
        if(empty($category)){
            $formErrors[]='Item Category Must Be Not Empty';
        }


         //check if theres no error proced the update operation 
         if (empty($formErrors)) {

            //insert user information in database

            $stmt = $con->prepare("INSERT INTO items(Name , Description ,Price ,Country_Made ,Status,Add_Date,Cat_ID,Member_ID,tags) VALUES(:name , :desc,:price,:country,:status,now(),:cat,:member,:tags)");
            $stmt->execute(array(
                'name' => $name,
                'desc' => $desc,
                'price' => $price,
                'country' => $country,
                'status' => $status,
                'cat' => $category,
                'member' => $_SESSION['uid'],
                'tags' => $tags
            ));
            //print seccess massage ;
             if($stmt){
                $succesMsg='item has been added';
             }
       
            }
        }
 else {

    // echo "<div class='container'>";
    // $themsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
    // redirectHome($themsg);
    // echo "</div>";
}

?>
    <h2 class="text-center"><?php echo $pageTitle; ?></h2>
    <div class="create-ad block">

        <div class="container">
            <div class="card ">
                <div class="card-header progress-bar "><?php echo $pageTitle; ?></div>
                <div class="card-body content-newad">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal " action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                <!-- start name field-->
                                <div class="form-group row ">
                                    <label class="col-sm-2">Name :</label>
                                    <div class="col-md-9 col-sm-10 ">
                                        <input pattern=".{4,}" title="this field requir at least 4 characters"
                                        type="text" name="name" class="form-control live" placeholder="Item name" data-class=".live-title" />
                                    </div>
                                </div>
                                <!-- end name field-->
                                <!-- start Description field-->
                                <div class="form-group row ">
                                    <label class="col-sm-2 control-label">Description :</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input pattern=".{10,}" title="this field requir at least 10 characters" type="text" name="description" class="form-control live" placeholder="Description of the item" data-class=".live-desc" />
                                    </div>
                                </div>
                                <!-- end Description field-->
                                <!-- start price field-->
                                <div class="form-group row ">
                                    <label class="col-sm-2 control-label">Price :</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="price" class="form-control live" placeholder="price of the item" data-class=".live-price"/>
                                    </div>
                                </div>
                                <!-- end price field-->
                                <!-- start country field-->
                                <div class="form-group row form-group-lg">
                                    <label class="col-sm-2 control-label">Country :</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="country" class="form-control" placeholder="country of Made" />
                                    </div>
                                </div>
                                <!-- end country field-->
                                <!-- start status field-->
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Status :</label>
                                    <div class="col-sm-10 col-md-9 ">
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
                            
                                <!-- start categories field-->
                                <div class="form-group row ">
                                    <label class="col-sm-2 control-label">Category :</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select name="category" id="">
                                            <option value="0">...</option>
                                            <?php
                                            $cats=getAllFrom('*','categories','','','ID');
                                          
                                            foreach ($cats as $cat) {
                                                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- end categories field-->
                                 <!-- start tags field-->
                                        <div class="form-group row form-group-lg">
                                            <label class="col-sm-2 control-label">Tags :</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="tags" class="form-control" placeholder="separate tags with comma(,)" />
                                            </div>
                                        </div>
                                <!-- end tags field-->
                                <!-- start add button field-->
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                                    </div>
                                </div>
                                <!-- end add button field-->
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail item-box live-preview">
                                <span class="price-tag">
                                    $ <span class="live-price">0</span>
                                    
                                </span>

                                <img class="img-responsive" src="layout/images/images.png" alt="">
                                <div class="option">
                                    <h3 class="live-title">Title</h3>
                                    <p class="live-desc">Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Looping Through Errors -->
                    <?php
                         if(! empty($formErrors)){
                             foreach($formErrors as $error){
                                  echo '<div class="alert alert-danger">'.$error.'</div>';
                             }
                         }
                         if(isset($succesMsg)){
                            echo '<div class="alert alert-success">'.$succesMsg.'</div>';
                          }
                      ?>

                     <!-- End Looping Through Errors -->
                </div>
            </div>
        </div>
    </div>

<?php } else {
    header('Location: login.php');
    exit();
}


include $tpl . "footer.php";
?>