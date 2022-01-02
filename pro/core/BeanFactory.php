<?php

namespace Core;


use DI\ContainerBuilder;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Doctrine\Common\Annotations\AnnotationRegistry;


class BeanFactory
{
    
    //配置文件
    private static $env=[];
    //IOC容器
    private static  $container;
    
    //初始化函数
    public static function init()
    {
        self::$env = parse_ini_file(ROOT_PATH."/.env");
        //var_dump(self::$env);
        /**
         * array(2) {
        ["scan_dir"]=>
        string(17) "./app/controllers"
        ["scan_root_namespace"]=>
        string(4) "App\"
        }
         */
        //初始容器Builder
        $builder = new ContainerBuilder();
        //启用注释 主要是用它的Inject注释
        $builder->useAnnotations(true);
        //容器初始化
        self::$container=$builder->build();
        //扫描(重点)
        self::ScanBeans();
        
    }
    
    //获取env文件的配置内容
    private static function _getEnv(string $key,string $default='')
    {
        if (isset(self::$env[$key]))
            return self::$env[$key];
        return $default;
    }
    
    public static function ScanBeans()
    {
        $annoHandles = require_once (ROOT_PATH."/core/annotations/AnnotationHandler.php");
        $scanDir = self::_getEnv("scan_dir",ROOT_PATH."/app");
        $scanRootNamespace = self::_getEnv("scan_root_namespace","APP\\");
        //glob() 函数返回匹配指定模式的文件名或目录
        //搜索要扫描目录下的php文件 返回文件名称
        $files = glob($scanDir."/*.php");
        foreach ($files as $file){
            require_once $file;
        }
        //注释类对象
        
        $reader = new AnnotationReader();
        //AnnotationRegistry::registerAutoloadNamespace('Core\annotations');
        
        AnnotationRegistry::registerLoader('class_exists'); //回调需返回true
        //get_declared_classes返回由已定义类的名字所组成的数组
        foreach (get_declared_classes() as $class){
           if (strstr($class,$scanRootNamespace)){
               $refClass = new \ReflectionClass($class);
               //获取所有类的注释
               $classAnnos = $reader->getClassAnnotations($refClass);
               foreach ($classAnnos as $classAnno){
                   //根据注释的类型获取对应处理方法
                   $hander = $annoHandles[get_class($classAnno)];
                   $hander(self::$container->get($refClass->getName()),self::$container);
                   
                   
               }
               
           }
        }
    }
    
    public static function getBean($name)
    {
        return self::$container->get($name);
    }
}