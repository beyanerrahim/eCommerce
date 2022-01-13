<?php

session_start();
$pageTitle = 'Show Item';
include "init.php";

// chek if get request itemid is numeric & get the integer value of it
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?  intval($_GET['itemid']) : 0;

// select all data depend on this ID
$stmt = $con->prepare("SELECT items.*,
            categories.Name as category_name,
            users.Username FROM items
            inner join categories on categories.ID = items.Cat_ID
            inner join users on users.UserID = items.Member_ID
            where item_ID=? and Approve=1");
//Execute Query
$stmt->execute(array($itemid));

$count = $stmt->rowCount();
//Fetch the data

if ($count > 0) {
    $item = $stmt->fetch();

?>
    <h2 class="text-center"><?php echo $item['Name'] ?></h2>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img class="img-responsive img-thumbnail center-block" src="layout/images/images.png" alt="">
            </div>
            <div class="col-md-9 item-info">
                <h3><?php echo $item['Name'] ?></h2>
                    <p><?php echo $item['Description'] ?></p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Date : </span><?php echo $item['Add_Date'] ?>
                        </li>
                        <li>
                            <i class="fa fa-money fa-fw"></i>
                            <span>Price : </span><?php echo $item['Price'] ?>
                        </li>
                        <li>
                            <i class="fa fa-building fa-fw"></i>
                            <span>Made In :</span> <?php echo $item['Country_Made'] ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Category : </span><a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name'] ?></a>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By : </span><a href="#"><?php echo $item['Username'] ?></a>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Tags: </span>
                            <?php
                                  $alltags = explode(",",$item['tags']);
                                  foreach($alltags as $tag){
                                      $tag=str_replace(' ','',$tag);
                                      $lowertag = strtolower($tag);
                                      if(~ empty($tag)){
                                      echo "<a href='tags.php?name={$lowertag}'>".$tag .'</a> |';
                                      }
                                  }

                            ?>
                        </li>
                    </ul>
            </div>
        </div>
        <hr class="custom-hr">
        <!-- Start Add Comment -->
        <?php if (isset($_SESSION['user'])) { ?>
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-offset-3">
                    <div class="add-comment">
                        <h3>Add Your Comment</h3>
                        <form action="" method="POST">
                            <textarea name="comment" required></textarea>
                            <input class="btn btn-primary" type="submit" value="Add Comment">
                        </form>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $userid = $item['Member_ID'];
                            $itemid = $_SESSION['uid'];

                            if (!empty($comment)) {
                                $stmt = $con->prepare("INSERT INTO 
                                 comments(comment , `status` , comment_date , item_id , `user_id`)
                                 VALUES(:zcomment , 0 ,now(), :zitemid , :zuserid)");

                                $stmt->execute(array(

                                    'zcomment' => $comment,
                                    'zitemid' => $itemid,
                                    'zuserid' => $userid
                                ));

                                if ($stmt) {
                                    echo '<div class="alert alert-success">Comment Added</div>';
                                }
                            }
                        }

                        ?>
                    </div>
                </div>
            </div>
            <!-- end Add Comment -->
        <?php } else {
            echo '<a href="login.php">Login</a> or<a href="login.php"> register </a>to Add Comment';
        } ?>
        <hr class="custom-hr">
        <?php

        // select all except admin 
        $stmt = $con->prepare("SELECT comments.*,users.Username as Member  FROM comments
            INNER JOIN users ON users.UserID = comments.user_id
            where item_id=? AND status = 1
            order by c_id DESC
            ");
        $stmt->execute(array($item['item_ID']));
        //assaign to varible
        $comments = $stmt->fetchAll();


        ?>
        <?php
        foreach ($comments as $comment) { ?>
            <div class="comment-box">
                <div class="row">
                    <div class="col-sm-2 text-center mb-3">
                        <img class="img-responsive img-thumbnail rounded-circle  " src="layout/images/images.png" alt="">
                        <?php echo $comment['Member']; ?>
                    </div>
                    <div class="col-sm-10">
                        <p class="lead">
                            <?php echo $comment['comment']; ?>
                        </p>
                    </div>
                </div>
                <hr class="custom-hr">
            </div>
        <?php  }

        ?>

    </div>


<?php
} else {
    echo '<div class="container">';
    echo '<div class="alert alert-danger">there is no such id or this item is waiting Aproval</div>';
    echo '</div>';
}

include $tpl . "footer.php";
?>