<?php

namespace Core\Http;


class Response
{
    
    /**
     * @var \Swoole\Http\Response
     */
    protected $swooleResponse;
    protected $body;
    
    /**
     * Response constructor.
     *
     * @param $swooleResponse
     */
    public function __construct($swooleResponse)
    {
        $this->swooleResponse = $swooleResponse;
        $this->_setHeader("Content-Type","text/plain;charset=utf-8");
        
    }
    private  function  _setHeader($key,$value)
    {
        //https://wiki.swoole.com/#/http_server?id=header
        $this->swooleResponse->header($key,$value);
    }
    
    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
    
    public static function  init(\Swoole\Http\Response $response)
    {
        return new self($response);
        
    }
    
    public function end($res)
    {
        $jsonConver = ['array'];  //自动变成json格式
        $res = $this->getBody();
        if(in_array( gettype($res),$jsonConver)){ //string array object
            $this->swooleResponse->header("Content-type","application/json;charset=utf-8");
            $res = json_encode($res);
        }
        
        $this->swooleResponse->write($res);
        $this->swooleResponse->end();
    }
    
    public function writeHtml($html)
    {
       
       $this->swooleResponse->write($html);
    }
    
    /**
     * 状态码
     * @param int $code
     */
    public function writeHttpStatus(int $code)
    {
        $this->swooleResponse->status($code);
    }
    
    /**
     * @param string $url
     * @param int    $code 301 永久跳转 302 零时跳转
     */
    public function writeRedirect(string $url,int $code=302)
    {
        //$this->swooleResponse->redirect($url,$code); //此方法跳转后服务器会报错
        //Warning: Swoole\Http\Response::header(): Http request is finished. in /pro/pro/core/http/Response.php on line 59
        $this->writeHttpStatus($code);
        $this->_setHeader("Location",$url);
    }
    
}