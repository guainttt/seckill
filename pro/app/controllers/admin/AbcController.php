<?php

namespace App\controllers;
use Core\http\Request;
use Core\annotations\Bean;
use Core\annotations\Value;
use Core\annotations\RequestMapping;
use Core\http\Response;

/**
 * Class UserController
 * 使用Bean注解加载类
 * 要用双引号！！
 * @Bean(name="abc")
 * @package App\controllers
 */
class AbcController
{
    
    /**
     * @Value(name="version")
     * @var string
     */
    public $version = '1.0';
    
    /**
     * @RequestMapping(value="/test2")
     *
     */
    public function test()
    {
       return "333";
    }
    
}