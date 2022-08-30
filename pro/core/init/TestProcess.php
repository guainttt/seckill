<?php

namespace Core\init;
use Core\helper\FileHelper;
use Swoole\Process;

class TestProcess
{
    private $md5file;
    public function run()
    {
        
        $process = new Process(function() {
            while (true) {
                //echo "ttt".PHP_EOL;
                sleep(3);
                
                $md5Value = FileHelper::getFileMd5(ROOT_PATH.'/app/*','/app/config');
               
                if ($this->md5file==''){
                    $this->md5file = $md5Value;
                    continue;  //放弃本次循环中continue语句之后的代码并进行下一次循环
                }
                //strcmp函数是string compare(字符串比较)的缩写，用于比较两个字符串并根据比较结果返回整数。基本形式为strcmp(str1,str2)，若str1=str2，则返回零；若str1<str2，则返回负数；若str1>str2，则返回正数
                //文件有改动
                if (strcmp($this->md5file,$md5Value)!==0){
                   
                    echo "代码有改动，重新加载ing".PHP_EOL;
                    $getPid = intval(file_get_contents("./ttt.pid"));
                    Process::kill($getPid,SIGUSR1);
                    $this->md5file = $md5Value;
                    echo "重新加载ed".PHP_EOL;
                }
            }
            
            
        });
        return  $process;
    }
}