<?php

namespace Core\annotationhandlers;

use Core\annotations\DB;
use Core\BeanFactory;
use Core\init\MyDB;



return [
    /**
     * @prop
     * object(ReflectionProperty)#48 (2) {
    ["name"]=>
    string(2) "db"
    ["class"]=>
    string(30) "App\controllers\UserController"
    }
 
     * @instance
     * object(App\controllers\UserController)#52 (2) {
    ["db":"App\controllers\UserController":private]=>
    NULL
    ["version"]=>
    string(3) "1.0"
    }
 
     * @self
     * object(Core\annotations\DB)#55 (1) {
    ["source"]=>
    string(6) "docker"
    }
     */
    /**
     * DB类的Handler
     */
  DB::class=>function(\ReflectionProperty $prop,$instance,$self) {
      $mydbBean = BeanFactory::getBean(MyDB::class);   //获取IOC容器的对象
      $mydbBean ->setDbSource($self->source);
      if ($self->sourc!=='default'){
          $newBeanName = MyDB::class."_".$self->source;
          $newBean =  BeanFactory::getBean($newBeanName);
          if(!$newBean){
              $newBean = clone  $mydbBean ;
              $newBean ->setDbSource($self->source);//默认为annotations/DB 里设置的数据源
              BeanFactory::setBean($newBeanName,$newBean);
          }
          $mydbBean =   $newBean;
      }
      $prop->setAccessible(true);   //
      //ReflectionProperty::setValue( object $object , mixed $value )
      //$instance 如果该属性是非静态的，则必须提供一个对象以更改该属性。 如果属性是静态的，则忽略此参数，仅需要提供值。
      //$mydbBean 新的属性值
      //把lvDB装载到UserController的实例里
      $prop->setValue($instance,$mydbBean);
      return $instance;
  }
];