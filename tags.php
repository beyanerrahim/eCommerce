<?php

   include "init.php";?>


<div class="container">
    <h2 class="text-center">Show items by tags</h2>
    <div class="row">
    <?php
          //$category=isset($_GET['pageid']) && is_numeric($_GET['pageid']) ?  intval($_GET['pageid']) : 0;
        if(isset($_GET['name'])){
            $tag = $_GET['name'];
            echo "<h2 class='text-center>".$tag."</h1>";
            $tagitems =  getAllFrom("*","items","where tags like '%$tag%'","And Approve = 1","item_ID");
            foreach($tagitems as $item){
            echo '<div class="col-md-3 col-sm-6">';
                 echo '<div class="thumbnail item-box">';
                       echo '<span class="price-tag">'. $item['Price'] .'</span>';                      
                       echo '<img class="img-responsive" src="layout/images/images.png" alt="">';
                       echo '<div class="option">';
                             echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">'.$item['Name'].'</a></h3>';
                             echo '<p>'.$item['Description'].'</p>';
                             echo '<div class="date">' . $item['Add_Date'] . '</div>';
                       echo '</div>';
                 echo '</div>';
            echo '</div>';     
        }
    }else{
        echo 'you must add page id';
    }
    
    ?>
    </div>
</div>


<?php
   include $tpl . "footer.php";
?>
