<?php

function lang($phrase){
     static $lang = array(
           // dashboard page
          
           'HOME_ADMIN' => 'Home ',
           'GATEGORIES'=> 'Categories',
           'ITEMS'=>'Items',
           'MEMBERS'=>'Members',
           'COMMENTS'=>'comments',
           'STATISTIC'=>'Statistic',
           'LOGS'=>'Logs'
          

     );
    return $lang[$phrase];
}

