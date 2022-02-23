<?php

namespace App\controllers;
use Core\annotations\Bean;
use Core\annotations\Value;
use Core\annotations\RequestMapping;

/**
 * Class UserController
 * 使用Bean注解加载类
 * 要用双引号！！
 * @Bean(name="abc")
 * @package App\controllers
 */
class UserController
{
    
    /**
     * @Value(name="version")
     * @var string
     */
    public $version = '1.0';
    
    /**
     * @RequestMapping(value="/user/test")
     *
     */
    public function test()
    {
       return "路由注释";
    }
    
}