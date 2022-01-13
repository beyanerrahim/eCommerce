<?php

   include "init.php";?>


<div class="container">
    <h2 class="text-center">Show Category items</h2>
    <div class="row">
    <?php
          //$category=isset($_GET['pageid']) && is_numeric($_GET['pageid']) ?  intval($_GET['pageid']) : 0;
        if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
            $category = intval($_GET['pageid']);
          foreach(getItems('Cat_ID',$category) as $item){
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
