<?php
   session_start();
   $pageTitle ='Home Page';
   include "init.php";?>


   <div class="container">
   
   <div class="row">
   <?php
      $all = getAllFrom('*','items','WHERE Approve = 1','','item_ID');
       foreach( $all as $item){
           echo '<div class="col-md-3 col-sm-6">';
                echo '<div class="thumbnail item-box">';
                      echo '<span class="price-tag">$'. $item['Price'] .'</span>';                      
                      echo '<img class="img-responsive" src="layout/images/images.png" alt="">';
                      echo '<div class="option">';
                            echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">'.$item['Name'].'</a></h3>';
                            echo '<p>'.$item['Description'].'</p>';
                            echo '<div class="date">' . $item['Add_Date'] . '</div>';
                      echo '</div>';
                echo '</div>';
           echo '</div>';     
       }
   ?>
   </div>
</div>





       



<?php
   include $tpl . "footer.php";
   ob_end_flush();
?>
