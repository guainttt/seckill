<?php

namespace Core\http;


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
    
    public function end()
    {
        $this->swooleResponse->write($this->getBody());
        $this->swooleResponse->end();
    }
}