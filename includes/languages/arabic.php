<?php

function lang($phrase){
     static $lang = array(
           'message'=> 'رسالة',
           'admin' => 'مسؤول',
     );
    return $lang[$phrase];
}

