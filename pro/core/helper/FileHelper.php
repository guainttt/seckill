<?php
namespace Core\helper;
class FileHelper
{
    /**
     * 获取文件监控变化
     * @param $dir         要扫描的目录
     * @param $ignore      忽略的目录     h
     *
     * @return string
     */
    public static function getFileMd5($dir,$ignore)
    {
        $files = glob($dir);
        $ret = [];
        foreach ($files as $file){
            if (is_dir($file) && strpos($file,$ignore)===false){
                //如果是文件夹，则递归，注意要加上/*，否则获取不到内容
                $ret[] = self::getFileMd5($file."/*",$ignore);
            }elseif (pathinfo($file)["extension"]=="php"){
                $ret[] = md5_file($file);
            }
        }
        return md5(implode('',$ret));//返回文件md5值
    }
    

}