<?php
namespace Core\server;
use Swoole\Http\Server;

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
        $this->server  = new \Swoole\Http\Server('0.0.0.0',80);
        //配置参数 https://wiki.swoole.com/#/server/setting
        $this->server->set(array(
          'worker_num'=>1,     //设置启动的 Worker 进程数。【默认值：CPU 核数】
          'daemonize'=>false     // 使用docker 不需要设置守护进程
        ));
        //$this->server->on('request',function ($req,$res){});
        $this->server->on('request',[$this,'onRequset']);
    
        $this->server->on('Start',[$this,'onStart']);
        
        $this->server->on('ShutDown',[$this,'onShutDown']);
        //$http->start();
        
    }
    
    public function onRequset($req,$res)
    {
    
    }
    
    
    public function onStart(Server $server )
    {
        $mid =  $server->master_pid;   //返回当前服务器主进程的 PID。
        file_put_contents("./ttt.pid",$mid);  //会覆盖
    }
    
    public function onShutDown(Server $server)
    {
        echo '关闭了'.PHP_EOL;
        unlink("./ttt.pid");
    }
    
    public function run()
    {
        $this->server->start();
    }
}