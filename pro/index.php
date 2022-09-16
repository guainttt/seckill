<?php
//https://github.com/nikic/FastRoute
require_once __DIR__.'/vendor/autoload.php';
use Swoole\Http\Request;
use Swoole\Http\Response;

//注册路由
/*$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r){
   $r->addRoute('GET','/test',function (){   define
       return 'my test';
   });
});*/

require_once __DIR__."/app/config/define.php";
/*\Core\BeanFactory::init();
$dispatcher = \Core\BeanFactory::getBean('RouterCollector')->getDispatcher();*/


$http  = new Swoole\Http\Server("0.0.0.0",80);

$http->on('request',function (Request $request,Response $response) use($dispatcher) {
    
    //匹配当前的url
    //$routeInfo = $dispatcher->dispatch($request->server['request_method'],$request->server['request_uri']);
    $myRequest = \Core\http\Request::init($request);
    $myResponse = \Core\http\Response::init($response);


    $routeInfo = $dispatcher->dispatch($myRequest->getMethod(),$myRequest->getUri());
    //$routeInfo返回一个数组，[表示是否注册过的路由,handle,参数]
    switch ($routeInfo[0]) {
        //有没有这个路由
        case FastRoute\Dispatcher::NOT_FOUND:
            // ... 404 Not Found 结束响应
            $response->status(404);
            $response->end();
            break;
        //请求方式
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            //$allowedMethods = $routeInfo[1];
            // ... 405 Method Not Allowed
            $response->status(405);
            $response->end();
            break;

        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];//参数
            //var_dump($vars);
           /* array(1) {
                        ["uid"]=>
              string(3) "123"
            }*/
            // ... call $handler with $vars
            $extVars = [$myRequest,$myResponse];
            // $vars 路由上带的参数
            // $extVars 附加参数 传入 Request 、Response对象等
            //$response->end($handler($vars,$extVars)); //最终执行的目标方法
            $myResponse->setBody($handler($vars,$extVars));
            $myResponse->end();
            break;
    }
    
});
$http->start();


/*$http->on('request',function (Request $request,Response $response){
    $html = $request->server['request_uri'];
   
    if($request->server['request_uri']=='/test'){
        $response->end("<h1>test</h1>");
        return;
    }
    $response->end("<h1>hello</h1>");
});
$http->start();*/
