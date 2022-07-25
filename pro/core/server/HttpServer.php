<?php
namespace Core\Server;


use Core\init\TestProcess;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

class HttpServer
{
    private $server;
    
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
        require_once (__DIR__."./../../test3.php");
        cli_set_process_title("ttt worker"); //设置进程名称
    }
    
    public function onRequset(Request $request,Response $response)
    {
        
        $response->end(showMe());
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
        $p = new TestProcess();
        $this->server->addProcess($p->run());
        $this->server->start();
    }
}