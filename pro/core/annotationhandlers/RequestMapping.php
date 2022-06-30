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
     
     $RouterCollector-> addRouter($requestMethod,$path,function($params,$extParams) use($method,$instance){
         //return $method->invoke($instance);//执行反射方法
         $inputParams=[];
         //得到方法的反射参数 比如 (Request $r,int $uid,int $aaa)
         $refParams=$method->getParameters();
         
        /* var_dump($refParams);
         exit;*/
         //value="/user/{uid:\d+}"
            /*[0]=>
              object(ReflectionParameter)#35 (1) {
              ["name"]=>
                string(3) "uid"
              }*/
         foreach ($refParams as $refParam){
             if(isset($params[$refParam->getName()])){
                 $inputParams[] =  $params[$refParam->getName()];
             }else{
                 //$extVar 都是实例对象，比如 Request 、Response
                 foreach($extParams as $extParam){
                     if($refParam->getClass() &&  $refParam->getClass()->isInstance($extParam)){
                         $inputParams[]  = $extParam;
                         //continue;      //有bug 之跳出本次   foreach 没有跳出上一次
                         goto abc;
                     }
                 }
                 $inputParams[] = false;
             }
             abc:
         }
         return $method->invokeArgs($instance,$inputParams);
     });
    
     return $instance;
    
    }
];