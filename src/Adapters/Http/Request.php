<?php

namespace Api\Adapters\Http;

class Request {

    private $httpMethod;
    private $uri;
    private array $data;

    public function __construct()
    {
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri          = $_SERVER['REQUEST_URI'] ?? '';
    }
    
    public function execute():void
    {
        
        if($this->httpMethod != 'POST')
        {
            if(file_get_contents('php://input') != '')
                $this->data = json_decode(file_get_contents('php://input'), true);
            else
                $this->data = [];

            return;
        }

        $this->data = $_POST;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getData()
    {      
        return $this->data;
    }
}
