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
    private static $container;
    private static $handlers = [];
    
    
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
        //self::$handlers = require_once(ROOT_PATH."/core/annotations/AnnotationHandler.php");
        $handlers = glob(ROOT_PATH."/core/annotationhandlers/*.php");
        foreach ($handlers as $handler){
            self::$handlers = array_merge(self::$handlers,require_once($handler));
        }
        //设置注解加载类
        $loader = require  __DIR__."/../vendor/autoload.php";
        AnnotationRegistry::registerLoader([$loader,'loadClass']);
        
        //扫描(重点)
        $scans = [
          //必须扫描的文件夹
          ROOT_PATH."/core/init"=>"Core\\",
          //用户配置的扫描路径
          self::_getEnv("scan_dir",ROOT_PATH."/app")=> self::_getEnv("scan_root_namespace","APP\\")
        ];
        //$scanDir = self::_getEnv("scan_dir",ROOT_PATH."/app");
        //$scanRootNamespace = self::_getEnv("scan_root_namespace","APP\\");
        foreach ($scans as $scanDir=> $scanRootNamespace){
            self::ScanBeans($scanDir,$scanRootNamespace);
        }
       
        
        
    }
    
    //获取env文件的配置内容
    private static function _getEnv(string $key,string $default='')
    {
        if (isset(self::$env[$key]))
            return self::$env[$key];
        return $default;
    }
    
    /**
     * 扫描env文件里scan_dir目录下的所有文件
     * @param $dir
     */
    private static function getAllBeanFiles($dir)
    {
        $ret = [];
        //glob() 函数返回匹配指定模式的文件名或目录
        //搜索要扫描目录下的php文件 返回文件名称
        $files = glob($dir."/*");
        foreach ($files as $file){
            if(strpos($file,'废弃')){
               
            }elseif(is_dir($file)){
              //递归合并，防止数组变成嵌套数组
              $ret = array_merge($ret,self::getAllBeanFiles($file));
            }elseif (pathinfo($file)["extension"]=="php"){
              $ret[] = $file;
            }
        }
        return $ret;
    }
    public static function ScanBeans($scanDir,$scanRootNamespace)
    {
        $files = self::getAllBeanFiles($scanDir);
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
                   $hander = self::$handlers[get_class($classAnno)];
                   $instance = self::$container->get($refClass->getName());
                   //处理属性注解
                   self::handlerPropAnno($instance,$refClass,$reader);
                   //处理方法注解
                   self::handlerMethodAnno($instance,$refClass,$reader);
                   
                   //处理类注解
                   $hander($instance,self::$container,$classAnno);
               }
           }
        }
    }
    
    public static function getBean($name)
    {
        return self::$container->get($name);
    }
    
    private static function handlerPropAnno(&$instance,\ReflectionClass $refClass,AnnotationReader $reader)
    {
       //读取反射对象的属性
        $props = $refClass->getProperties();
        foreach ($props as $prop){
            //$prop必须是反射对象属性
            $propAnnos = $reader->getPropertyAnnotations($prop);
            foreach ($propAnnos as $propAnno){
                //返回对象实例 obj 所属类的名字。如果 obj 不是一个对象则返回 FALSE
                $handler = self::$handlers[get_class($propAnno)];
                $handler($prop,$instance,$propAnno);
            }
        }
    }
    
    
    /**
     * 处理方法注解
     * @param                                               $instance
     * @param \ReflectionClass                              $refClass
     * @param \Doctrine\Common\Annotations\AnnotationReader $reader
     */
    private static function handlerMethodAnno(&$instance,\ReflectionClass $refClass,AnnotationReader $reader)
    {
        //读取反射对象的属性
        $methods = $refClass->getMethods();//取出所有的方法
        foreach ($methods as $method){
            //$prop必须是反射对象属性
            $methodAnnos = $reader->getMethodAnnotations($method);
            foreach ($methodAnnos as $methodAnno){
                //返回对象实例 obj 所属类的名字。如果 obj 不是一个对象则返回 FALSE
                $handler = self::$handlers[get_class($methodAnno)];
                $handler($method,$instance,$methodAnno);
            }
        }
    }
    
}