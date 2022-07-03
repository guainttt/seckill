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
class UserController
{
    
    /**
     * @Value(name="version")
     * @var string
     */
    public $version = '1.0';
    
    /**
     * @RequestMapping(value="/test")
     *
     */
    public function test()
    {
       return "...aa";
    }
    
    
    /**
     * @RequestMapping(value="/aaa/{uid:\d+}")
     */
    public function aaa()
    {
        return "aaa---";
        
    }
    
    /**
     * @RequestMapping(value="/user/{uid:\d+}")
     * 讲Request对象注入到
     * $aaa 干扰参数 没什么用 冗余
     */
    public function user(int $bbb,Request $r,int $uid,int $aaa,Response $response)
    {
        
       // var_dump($r);
        //var_dump($r->getQueryParams());
        //$response->testWrite('abc');
        //return "bbb---".$uid;
        //$response->writeHtml('你好');
        //$response->writeHttpStatus(404);
        $response->writeRedirect('http://jtthink.com');
        //return ['uid'=>$uid,'username'=>'ttt'];
    }
    
}