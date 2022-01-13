<?php
session_start();
$pageTitle = 'Profile';
include "init.php";

if (isset($_SESSION['user'])) {
    $getUser = $con->prepare('SELECT * FROM users WHERE Username = ?');

    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    $userid=$info['Username'];


?>
    <h2 class="text-center">My Profile</h2>
    <div class="information block">

        <div class="container">
            <div class="card panel-primary">
                <div class="card-header progress-bar">My information</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            Name : <?php echo $info['Username']; ?>
                        </li>                    
                        <li> 
                        <i class="fa fa-envelope-o fa-fw"></i>
                            Email: <?php echo $info['Email']; ?>
                        </li>
                        <li>
                        <i class="fa fa-user fa-fw"></i>
                            Full Name: <?php echo $info['FullName']; ?>
                        </li>
                        <li>
                        <i class="fa fa-calendar fa-fw"></i>
                            Register Date : <?php echo $info['Date']; ?>
                        </li>
                        <li>
                        <i class="fa fa-tags fa-fw"></i>
                            Favourite Category :
                        </li>
                    </ul>
                    <a href="" class="btn btn-primary my-button mt-2">Edit Information</a>
                </div>
            </div>
        </div>
    </div>
    <div id="my-ads"class="my-ads block">

        <div class="container">
            <div class="card card-primary">
                <div class="card-header progress-bar">My Advertisments</div>
                <div class="card-body">
                   
                        <?php
                         if (!empty(getItems('Member_ID', $info['UserID'] ))) {
                             echo '<div class="row">';
                        foreach (getItems('Member_ID', $info['UserID'] ,1) as $item) {
                            echo '<div class="col-md-3 col-sm-6">';
                            echo '<div class="thumbnail item-box">';
                            if($item['Approve'] == 0){
                                echo '<span class="approve-status">NOT Aproved</span>';
                            }
                            echo '<span class="price-tag">' . $item['Price'] . '</span>';

                            echo '<img class="img-responsive" src="layout/images/images.png" alt="">';
                            echo '<div class="option">';
                            echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">' . $item['Name'] . '</a></h3>';
                            echo '<p>' . $item['Description'] . '</p>';
                            echo '<div class="date">' . $item['Add_Date'] . '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }else{
                        echo 'Sorry  there is no ads to show , Create <a class="newad.php">New Ad</a>';
                    }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-comments block">

        <div class="container">
            <div class="card card-primary">
                <div class="card-header progress-bar">Latest Comments</div>
                <div class="card-body">
                    <?php

                    // select all except admin 
                    $stmt = $con->prepare("SELECT comment FROM comments where user_id = ? ");
                    $stmt->execute(array($info['UserID']));

                    //assaign to varible
                    $comments = $stmt->fetchAll();
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            echo '<p>' . $comment['comment'] . '</p>';
                        }
                    } else {
                        echo 'There Is Not Comments To Show';
                    }
                    ?>
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