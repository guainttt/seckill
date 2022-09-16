<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2021/11/12
 * Time: 23:25
 */

namespace App\test废弃;


class MyUser
{
    public $mydb;
    //$dsn配置
    // 1 正向控制 public function __construct($dsn)
    public function __construct(MyDB $DB)
    {
        //1 正向实例化 以myUser控制MyDB
        //$this->mydb = new MyDB($dsn);
        //MyUser不会主动去实例化DB 控制顺序发生了反转 起到了解耦的目的
        $this->mydb = $DB;
    }
    
    public function getAllUsers():array {
        return $this->mydb->gueryForRows('select * from users');
    }
}