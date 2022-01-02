<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__."/app/config/define.php";
\Core\BeanFactory::init();

$user = \Core\BeanFactory::getBean("UserController");
var_dump($user);

