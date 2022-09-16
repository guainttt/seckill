<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__."/app/config/define.php";

$db = new \Core\init\MyDB();
//$users = $db->table('users')->get();
$db->setDbSource('default') ;
$users =$db->table('users','u')->get();

foreach ($users as $user){
    echo $user->name;
}

