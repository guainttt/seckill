<?php
use Swoole\Http\Server;
use Swoole\Process;

if ($argc==2){
    $cmd = $argv[1];
    if ($cmd=='start'){
        $http = new Swoole\Http\Server('0.0.0.0',80);
        //配置参数 https://wiki.swoole.com/#/server/setting
        $http->set(array(
          'worker_num'=>1,     //设置启动的 Worker 进程数。【默认值：CPU 核数】
          'daemonize'=>false     // 使用docker 不需要设置守护进程
        ));
        $http->on('request',function ($req,$res){
        
        });
    
        $http->on('Start',function (Server $server ){
            $mid =  $server->master_pid;   //返回当前服务器主进程的 PID。
            file_put_contents("./ttt.pid",$mid);  //会覆盖
        });
        $http->start();
    
    } elseif ($cmd=='stop'){
        $mid = intval(file_get_contents("./ttt.pid"));
        if (trim($mid)){
            Process::kill($mid);
        }
    } else {
        echo '无效命令';
    }
}   else {
    echo '无效命令';
}







