<?php
namespace Core\Http;
class Request
{
   protected $server = [];
   protected $uri ;
   protected $queryParams;
   protected $postParams;
   protected $method;
   protected $header = [];
   protected $body;
   protected $swooleRequest;
    
    /**
     * Request constructor.
     *
     * @param array $server
     * @param       $uri
     * @param       $queryParams
     * @param       $postParams
     * @param       $method
     * @param array $header
     * @param       $body
     */
    public function __construct(
      array $server,
      $uri,
      $queryParams,
      $postParams,
      $method,
      array $header,
      $body
    ) {
        $this->server = $server;
        $this->uri = $uri;
        $this->queryParams = $queryParams;
        $this->postParams = $postParams;
        $this->method = $method;
        $this->header = $header;
        $this->body = $body;
    }
    
    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }
    
    /**
     * @param array $server
     */
    public function setServer(array $server): void
    {
        $this->server = $server;
    }
    
    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }
    
    /**
     * @param mixed $uri
     */
    public function setUri($uri): void
    {
        $this->uri = $uri;
    }
    
    /**
     * @return mixed
     */
    public function getQueryParams()
    {
        return $this->queryParams ? :[];
    }
    
    /**
     * @param mixed $queryParams
     */
    public function setQueryParams($queryParams): void
    {
        $this->queryParams = $queryParams;
    }
    
    /**
     * @return mixed
     */
    public function getPostParams()
    {
        return $this->postParams?:[];
    }
    
    /**
     * @param mixed $postParams
     */
    public function setPostParams($postParams): void
    {
        $this->postParams = $postParams;
    }
    
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }
    
    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }
    
    /**
     * @param array $header
     */
    public function setHeader(array $header): void
    {
        $this->header = $header;
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
    
    /**
     * @return mixed
     */
    public function getSwooleRequest()
    {
        return $this->swooleRequest;
    }
    
    /**
     * @param mixed $swooleRequest
     */
    public function setSwooleRequest($swooleRequest): void
    {
        $this->swooleRequest = $swooleRequest;
    }

    
    public static function init(\Swoole\Http\Request $swooleRequest)
    {
       $server  = $swooleRequest->server;
       //$a = $a ?? 1; 判断一个变量是a否存在，存在则赋值变量a,不存在赋值变量b
       $method  = $swooleRequest->server['request_method'] ?? 'GET';
       $uri     = $server['request_uri'];
       $body    = $swooleRequest->rawContent();
       
       $request = new self($server,$uri,$swooleRequest->get,$swooleRequest->post,$method,$swooleRequest->header,$body);
       
       $request->swooleRequest = $swooleRequest;
       return $request;
    }
    
    
}