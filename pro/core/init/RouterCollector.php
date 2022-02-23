<?php
namespace Core\init;
use Core\annotations\Bean;
/**
 * 路由收集器
 * @Bean()
 */
class RouterCollector
{
    public $routes = [];
    public function addRouter($method,$uri,$handler)
    {
       $this->routes[] = [
         'method'=>$method,
         'uri'=>$uri,
         'handler'=>$handler];
    }
}