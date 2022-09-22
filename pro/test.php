<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__."/app/config/define.php";
\Core\BeanFactory1111::init();

//三种方法都可以实现类的自动加载
//$user = \Core\BeanFactory1111::getBean("UserController");
//var_dump($user);
//$user = \Core\BeanFactory1111::getBean(\App\controllers\UserController::class);
//var_dump($user);
//$user = \Core\BeanFactory1111::getBean("abc");
//var_dump($user);

$routerCollector= \Core\BeanFactory1111::getBean("RouterCollector");
var_dump($routerCollector->routes);





