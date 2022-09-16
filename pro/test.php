<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__."/app/config/define.php";
\Core\BeanFactory::init();

//三种方法都可以实现类的自动加载
//$user = \Core\BeanFactory::getBean("UserController");
//var_dump($user);
//$user = \Core\BeanFactory::getBean(\App\controllers\UserController::class);
//var_dump($user);
//$user = \Core\BeanFactory::getBean("abc");
//var_dump($user);

$routerCollector= \Core\BeanFactory::getBean("RouterCollector");
var_dump($routerCollector->routes);





