<?php

return [
  'default'=>[
    'driver'    =>  'mysql',  //windows 服务器上的
    'host'      =>  '10.10.10.114',
    'port'      =>  '3306',
    'database'  =>  'test',
    'username'  =>  'ttt',
    'password'  =>  '123456',
    'charset'   =>  'utf8mb4',
    'collation' =>  'utf8mb4_general_ci',
    'prefix'    =>  '',
  ],
  "docker"=>[
    'driver'    =>  'mysql',
    'host'      =>  '10.10.10.234', //我的dicker上的    da9aad4acad8   mysql:5.6
    'port'      =>  '12345',
    'database'  =>  'seckill',
    'username'  =>  'root',
    'password'  =>  '123456',
    'charset'   =>  'utf8mb4',
    'collation' =>  'utf8mb4_general_ci',
    'prefix'    =>  '',
    ] 
  
];

