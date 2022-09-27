<?php

namespace App\controllers;
use Core\http\Request;
use Core\http\Response;

use Core\annotations\Bean;
use Core\annotations\Value;
use Core\annotations\RequestMapping;
use Core\annotations\DB;
use Core\init\MyDB;




/**
 * Class UserController
 * 使用Bean注解加载类
 * 要用双引号！！
 * @Bean(name="user")
 * @package App\controllers
 * //Spring的@Bean注解用于告诉方法，产生一个Bean对象，然后这个Bean对象交给Spring管理。产生这个Bean对象的方法Spring只会调用一次，随后这个Spring将会将这个Bean对象放在自己的IOC容器中；
 */
class UserController
{
    
   
    
    /**
     * @DB(source ="default")
     * @var MyDB
     */
    private $db1;
    
    /**
     * @DB(source ="docker")
     * @var MyDB
     */
    private $db2;
    
    /**
     * @Value(name="version")
     * @var string
     */
    public $version = '1.0';
    
    /**
     * @RequestMapping(value="/test")
     */
    public function test(Response $response )
    {
        $arr =  $this->db1->table("users",'u')->get();
        return $arr;
    }
    
    
    /**
     * @RequestMapping(value="/test3")
     */
    public function test3(Response $response )
    {
        $arr =  $this->db2->table("users",'u')->get();
        return $arr;
    }
    
    /**
     * @RequestMapping(value="/aaa/{uid:\d+}")
     */
    public function aaa()
    {
        return "1aaa";
        
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