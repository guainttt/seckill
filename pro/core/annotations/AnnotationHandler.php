<?php

namespace Core\annotations;
return [
    //类注解
    Bean::class=>function($instance,$container){
        //get_class返回对象的类名
       $arr = explode("\\",get_class($instance));
       $beanName = end($arr);
       $container->set($beanName,$instance);
    },
    //属性注解
    Value::class=>function(){
    
    }
];

