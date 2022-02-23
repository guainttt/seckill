<?php

namespace Core\annotationhandlers;
use Core\annotations\Bean;
use Core\annotations\Value;

return [
    //类注解
    Bean::class=>function($instance,$container,$classAnno=''){
       $vars = get_object_vars($classAnno);
       //自定义的beanName
        if (isset($vars['name']) && $vars['name']!=''){
            $beanName = $vars['name'];
            $container->set($beanName,$instance);
        }
        //get_class返回对象的类名
        $arr = explode("\\",get_class($instance));
        $beanName = end($arr);
        
       $container->set($beanName,$instance);
    },
    //属性注解
    Value::class=>function(\ReflectionProperty $prop,$instance,$propAnno=''){
        //读取env文件
        $env = parse_ini_file(ROOT_PATH."/.env");
        if (!isset($env[$propAnno->name]) || $propAnno->name=='' ){
           return $instance;
        }
        //setValue(object $object, mixed $value) ReflectionProperty类内置方法
        //$reflectionClass->getProperty('property')->setValue($foo, 'bar');
        $prop->setValue($instance,$env[$propAnno->name]);
        
    }
];

