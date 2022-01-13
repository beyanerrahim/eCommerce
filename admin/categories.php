<?php

/*
=============================================
== Category Page
=============================================
*/
ob_start();  //output buffering start
session_start();

$pageTitle = '';
if (isset($_SESSION['Username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        $sort = 'ASC';
        $sort_array = array('ASC', 'DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
            $sort = $_GET['sort'];
        }
        $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

        $stmt2->execute();

        $cats = $stmt2->fetchAll(); ?>

        <h2 class="text-center">
            Manage Categories</h2>
        <div class="container categories">
            <!-- <a class="btn btn-primary  add-cat" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a> -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit"></i>Manage categories
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i>Ordering :[
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="?sort=ASC">ASC</a> |
                        <a class="<?php if ($sort == 'DESC') {
                                        echo 'active';
                                    } ?>" href="?sort=DESC">DESC</a>]
                        <i class="fa fa-eye"></i>View :[
                        <span class="active" data-view="full">Full</span> |
                        <span data-view="classic">Classic</span>]

                    </div>

                </div>

                <div class="panel-body">
                    <?php
                    foreach ($cats as $cat) {
                        echo "<div class='cat'>";
                        echo "<div class='hidden-buttons'>";
                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                        echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";

                        echo "</div>";
                        echo "<h3>" . $cat['Name'] . '</h3>';
                        echo "<div class='full-view'>";
                        echo "<p>";
                        if ($cat['Description'] == '') {
                            echo 'this category has no description';
                        } else {
                            echo $cat['Description'];
                        }
                        echo '</p>';
                        if ($cat['Visibility'] == 1) {
                            echo '<span class="visibility"><i class="fa fa-eye"></i>Hidden</span>';
                        }
                        if ($cat['Allow_Comment'] == 1) {
                            echo '<span class="commenting"><i class="fa fa-close"></i>Comment Disabled</span>';
                        }
                        if ($cat['Allow_Ads'] == 1) {
                            echo '<span class="advertises"><i class="fa fa-close"></i>Ads Disabled</span>';
                        }
                        echo "</div>";
                        //Get child Categories
                        $childCats = getAllFrom("*", "categories", "where parent ={$cat['ID']}", "", "ID", "ASC");
                        if (!empty($childCats)) {
                            echo "<h4 class='child-head'>Child Categories</h4>";
                            echo "<ul class='list-unstyled child-cats'>";
                            foreach ($childCats as $c) {
                                echo "<li class='child-link'>
                                <a href='categories.php?do=Edit&catid=" . $c['ID'] . "' >" . $c['Name'] . "</a>
                                <a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm '>Delete</a>


                                </li>";
                            }
                            echo "</ul>";
                        }
                        echo "</div>";


                        echo "<hr>";
                    }

                    ?>

                </div>
            </div>
            <a class="btn btn-primary add-cat" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
        </div>

    <?php
    } elseif ($do == 'Add') { ?>
        <h2 class="text-center">Add new Category</h2>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <!-- start name field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Name:</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="category name" required />
                    </div>
                </div>
                <!-- end name field-->
                <!-- start Description field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Description:</label>
                    <div class="col-sm-10 col-md-6">

                        <input type="text" name="description" class="form-control" placeholder="Describe the category" autocomplete="new-password" />

                    </div>
                </div>
                <!-- end Description field-->
                <!-- start Ordering field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Ordering:</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange the categories" />
                    </div>
                </div>
                <!-- end Ordering field-->
                <!-- start category type -->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Parent ?</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="parent" id="">
                            <option value="0">None</option>
                            <?php
                            $allCats = getAllFrom("*", "categories", "Where parent = 0", "", "ID", "ASC");
                            foreach ($allCats as $cat) {
                                echo "<option value='" . $cat['ID'] . "'> " . $cat['Name'] . "</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <!-- End category type -->
                <!-- start visibility field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Visibility :</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1" />
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end visibility field-->
                <!-- start Commenting field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Allow Commenting :</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" />
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Commenting field-->
                <!-- start Ads field-->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads :</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Ads field-->
                <!-- start add button field-->
                <div class="form-group form-group-lg">
                    <div class=" col-md-4 col-sm-offset col-sm-10">
                        <input type="submit" value="Add category" class="btn btn-primary " />
                    </div>
                </div>
                <!-- end add button field-->
            </form>

        </div>


        <?php
    } elseif ($do == 'Insert') {
        //insert category page 

        // echo $_POST['username'] . $_POST['email'] . $_POST['password'] .$_POST['full'] ;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<h2 class='text-center'>Insert Category</h2>";
            echo "<div  class='container'>";

            //Get variables from the form

            $name = $_POST['name'];
            $desc = $_POST['description'];
            $parent = $_POST['parent'];
            $order = $_POST['ordering'];
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];


            //check if categorys exist in database 

            $check = checkItem('Name', 'categories', $name);
            if ($check == 1) {

                $themsg = "<div class='alert alert-danger'>sorry this category is exist</div>";
                redirectHome($themsg, 'back');
            } else {
                //insert category info in database

                $stmt = $con->prepare("INSERT INTO categories(Name ,Description , parent ,Ordering ,Visibility ,Allow_Comment,Allow_Ads) VALUES(:name , :desc,:parent,:order,:visible, :comment ,:ads)");
                $stmt->execute(array(
                    'name' => $name,
                    'desc' => $desc,
                    'parent' => $parent,
                    'order' => $order,
                    'visible' => $visible,
                    'comment' => $comment,
                    'ads' => $ads
                ));
                //print seccess massage ;

                $themsg = "<div class='alert alert-success'> " . $stmt->rowCount() . " Record inserted</div>";
                redirectHome($themsg, 'back');
            }
        } else {

            echo "<div class='container'>";
            $themsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
            redirectHome($themsg, 'back', 3);
            echo "</div>";
        }
        echo "</div>";
    } elseif ($do == 'Edit') {

        // chek if get request catid is numeric & get the integer value of it
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) : 0;

        // select all data depend on this ID
        $stmt = $con->prepare("SELECT * FROM categories where ID = ?");
        //Execute Query
        $stmt->execute(array($catid));
        //Fetch the data
        $cat = $stmt->fetch();
        //the row count
        $count = $stmt->rowCount();
        //if theres such id show the form
        if ($stmt->rowCount() > 0) {
        ?>

            <h2 class="text-center">Edit Category</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>" />
                    <!-- start name field-->
                    <div class="form-group row form-group-lg">
                        <label class="col-sm-2 control-label">Name:</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="category name" required value="<?php echo $cat['Name']; ?>" />
                        </div>
                    </div>
                    <!-- end name field-->
                    <!-- start Description field-->
                    <div class="form-group row form-group-lg">
                        <label class="col-sm-2 control-label">Description:</label>
                        <div class="col-sm-10 col-md-6">

                            <input type="text" name="description" class="form-control" placeholder="Describe the category" value="<?php echo $cat['Description']; ?>" />

                        </div>
                    </div>
                    <!-- end Description field-->
                    <!-- start Ordering field-->
                    <div class="form-group row form-group-lg">
                        <label class="col-sm-2 control-label">Ordering:</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange the categories" value="<?php echo $cat['Ordering']; ?>" />
                        </div>
                    </div>
                    <!-- end Ordering field-->
                     <!-- start category type -->
                <div class="form-group row form-group-lg">
                    <label class="col-sm-2 control-label">Parent ? </label>
                    <div class="col-sm-10 col-md-6">
                        <select name="parent" id="">
                            <option value="0">None</option>
                            <?php
                            $allCats = getAllFrom("*", "categories", "Where parent = 0", "", "ID", "ASC");
                            foreach ($allCats as $c) {
                                echo "<option value='" . $c['ID'] . "'";
                                if($cat['parent'] == $c['ID']){
                                   echo 'selected';
                                }
                                echo "> " . $c['Name'] . "</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <!-- End category type -->
                    <!-- start visibility field-->
                    <div class="form-group row form-group-lg">
                        <label class="col-sm-2 control-label">Visibility :</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0) {
                                                                                                    echo 'checked';
                                                                                                } ?> />
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1) {
                                                                                                echo 'checked';
                                                                                            } ?> />
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end visibility field-->
                    <!-- start Commenting field-->
                    <div class="form-group row form-group-lg">
                        <label class="col-sm-2 control-label">Allow Commenting :</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) {
                                                                                                    echo 'checked';
                                                                                                } ?> />
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) {
                                                                                                echo 'checked';
                                                                                            } ?> />
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Commenting field-->
                    <!-- start Ads field-->
                    <div class="form-group row form-group-lg">
                        <label class="col-sm-2 control-label">Allow Ads :</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Ads field-->
                    <!-- start add button field-->
                    <div class="form-group form-group-lg">
                        <div class=" col-md-4 col-sm-offset col-sm-10">
                            <input type="submit" value="Update" class="btn btn-primary " />
                        </div>
                    </div>
                    <!-- end add button field-->
                </form>

            </div>

<?php
            //if theres no such id show Error Message
        } else {
            echo "<div class='container'>";
            $themsg = '<div class="alert alert-danger">theres no such ID</div>';
            redirectHome($themsg);
            echo "</div>";
        }
       } elseif ($do == 'Update') {
        echo "<h2 class='text-center'>Update Category</h2>";
        echo "<div  class='container'>";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get variables from the form
            $id = $_POST['catid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $parent = $_POST['parent'];

            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];

            //Update the database with this Info
            $stmt = $con->prepare("UPDATE categories set Name = ?, Description = ?, Ordering = ? ,parent =?, Visibility =? , Allow_Comment =?, Allow_Ads =? where ID = ?");
            $stmt->execute(array($name, $desc, $order,$parent, $visible, $comment, $ads, $id));
            //print seccess massage ;

            $themsg = "<div class='alert alert-success'> " . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($themsg, 'back');
        } else {
            $errormsg = "<div class='alert alert-danger'>sorry you cant browser this page directly</div>";
            redirectHome($errormsg);
            //echo "sorry you cant browser this page directly";
        }
        echo "</div>";
    } elseif ($do == 'Delete') {
        echo "<h2 class='text-center'>Delete Category</h2>";
        echo "<div  class='container'>";

        // chek if get request catid is numeric & get the integer value of it
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) : 0;

        // select all data depend on this ID
        // $stmt = $con ->prepare("SELECT * FROM users where UserID = ? limit 1");
        $check = checkItem('ID', 'categories', $catid);
        //Execute Query
        // $stmt->execute(array($userid));

        //the row count
        //$count = $stmt->rowCount();

        //if theres such id show the form
        if ($check > 0) {

            $stmt = $con->prepare('DELETE FROM categories WHERE ID = :zid');
            $stmt->bindParam("zid", $catid);
            $stmt->execute();

            $themsg = "<div class='alert alert-success'> " . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($themsg, 'back');
        } else {
            $themsg = '<div class="alert alert-danger">this id is not Exist</div>';
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