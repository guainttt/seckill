<?php
//注入定义
namespace App\test废弃;
return [
  
  MyDB::class=>function (){
      return new   MyDB('mysql:host=localhost');
  },
    // my_user是我起的名，最好用   MyUser::class更规范化
/*  'my_user'=>function (\DI\Container $c){
      return new MyUser($c->get(mydb));
  },*/
  MyUser::class =>function (\DI\Container $c){
      return new MyUser($c->get(MyDB::class));
  }
];