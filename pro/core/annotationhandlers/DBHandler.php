<?php

namespace Core\annotationhandlers;

use Core\annotations\DB;
use Core\BeanFactory;
use Core\init\MyDB;



return [
  DB::class=>function(\ReflectionProperty $prop,$instance,$self) {
    $mydbBean = BeanFactory::getBean(MyDB::class);   //从新获取一个对象
    $mydbBean ->setDbSource($self->source);//新MyDB对象设置数据源
    
    $prop->setAccessible(true);   //
    $prop->setValue($instance,$mydbBean);
    
    return $instance;
  }
];