<?php
namespace Core\annotationhandlers;
use Core\annotations\RequestMapping;
use Core\BeanFactory;

return[
  //$methodAnnoSelf 注解本身
  RequestMapping::class=>function(\ReflectionMethod $method,$instance,$methodAnnoSelf){
    
     $path = $methodAnnoSelf->value;//uri;
     $requestMethod =  count($methodAnnoSelf->method)>0 ? $methodAnnoSelf->method:['GET'];
     $RouterCollector = BeanFactory::getBean("RouterCollector");
     
     $RouterCollector-> addRouter($requestMethod,$path,function() use($method,$instance){
         $method->invoke($instance);//执行反射方法
         
     });
    
     return $instance;
    
    }
];