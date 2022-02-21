<?php

namespace Api\Adapters\Http;

class Response
{
    private int $httpCode;
    private $headers = [];
    private $contentType = "application/json";
    private $content;

    public function __construct(mixed $content, int $httpCode = 200)
    {
        $this->httpCode = $httpCode;
        $this->content  = $content;
        $this->setContentType();
        $this->sendHeaders();
        $this->sendResponse();
    }

    private function setContentType()
    {
        $this->addHeader('Content-Type', $this->contentType);
        $this->addHeader('Access-Control-Allow-Origin', '*');
    }

    private function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    private function sendHeaders()
    {
        http_response_code($this->httpCode);

        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }
    }

    private function sendResponse()
    {
      echo json_encode($this->content, JSON_UNESCAPED_UNICODE);
    }
}
