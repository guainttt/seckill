<?php
namespace Core\Server;


use Core\init\TestProcess;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;




class HttpServer
{
    private $server;
    private $dispatcher; //路由
    
    /**
     * HttpServer constructor.
     *
     * @param $server
     */
    public function __construct()
    {
        $this->server  = new Server('0.0.0.0',80);
        //配置参数 https://wiki.swoole.com/#/server/setting
        $this->server->set(array(
          'worker_num'=>1,     //设置启动的 Worker 进程数。【默认值：CPU 核数】
          'daemonize'=>false     // 使用docker 不需要设置守护进程
        ));
        //$this->server->on('request',function ($req,$res){});
        $this->server->on('request',[$this,'onRequset']);
    
        $this->server->on('Start',[$this,'onStart']);
        
        $this->server->on('ShutDown',[$this,'onShutDown']);
        $this->server->on('WorkerStart',[$this,'onWorkerStart']);
        $this->server->on('ManagerStart',[$this,'onManagerStart']);
        //$http->start();
        
    }
    
    /**
     *
     * 此事件在worker进程、task进程启动时发生。这里创建的对象可以在进程生命周期内使用
     * @param \Swoole\Http\Server $server
     * @param int                 $workerId
     */
    public function onWorkerStart(Server $server,int $workerId)
    {
        //Server->reload  重启所有的worker或task进程
        //https://wiki.swoole.com/wiki/page/20.html
        //Linux信号列表
        //https://wiki.swoole.com/#/other/signal
        //require_once (__DIR__."./../../test3.php");
        cli_set_process_title("ttt worker"); //设置进程名称
    
        //把index文件里的代码搬过来
        \Core\BeanFactory::init();
        $this->dispatcher  = \Core\BeanFactory::getBean('RouterCollector')->getDispatcher();
    
    
    }
    
    public function onRequset(Request $request,Response $response)
    {
    
        //匹配当前的url
        //$routeInfo = $dispatcher->dispatch($request->server['request_method'],$request->server['request_uri']);
        $myRequest = \Core\http\Request::init($request);
        $myResponse = \Core\http\Response::init($response);
    
    
        $routeInfo = $this->dispatcher->dispatch($myRequest->getMethod(),$myRequest->getUri());
        //$routeInfo返回一个数组，[表示是否注册过的路由,handle,参数]
        switch ($routeInfo[0]) {
            //有没有这个路由
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found 结束响应
                $response->status(404);
                $response->end();
                break;
            //请求方式
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                //$allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                $response->status(405);
                $response->end();
                break;
        
            case \FastRoute\Dispatcher::FOUND:
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
                $ret =  $handler($vars,$extVars);
                $myResponse->setBody($ret);
                
                $myResponse->end();
                break;
        }
        //$response->end(showMe());
    }
    
    
    public function onStart(Server $server)
    {
        cli_set_process_title("ttt master"); //设置进程名称
        $mid =  $server->master_pid;   //返回当前服务器主进程的 PID。
        file_put_contents("./ttt.pid",$mid);  //会覆盖
    }
    
    public function onManagerStart(Server $server)
    {
        cli_set_process_title("ttt manager"); //设置进程名称
    }
    public function onShutDown(Server $server)
    {
        echo '关闭了'.PHP_EOL;
        unlink("./ttt.pid");
    }
    
    public function run()
    {
        $p = new TestProcess(); //文件监控
        $this->server->addProcess($p->run());
        $this->server->start();
    }
}