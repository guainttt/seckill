<?php
//pro根目录 定义一个ROOT_PATH
define("ROOT_PATH",dirname(dirname(__DIR__)));
$GLOBAL_CONFIGD= [
    'db'=> require_once (__DIR__."/db.php"),
    'redis'=>[]
] ;
//define("GLOBAL_CONFIGD",$GLOBAL_CONFIGD);