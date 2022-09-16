<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2021/11/12
 * Time: 23:24
 */

namespace App\test废弃;


class MyDB
{
    private $db;
    public function __construct($connInfo)
    {
    }
    
    public function gueryForRows($sql)
    {
        return ['uid'=>555];
    }
}