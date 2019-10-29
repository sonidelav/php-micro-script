<?php

class HttpResponse
{
    private $body;
    private $headers;
    private $asJson = false;
    
    public function __construct()
    {
        $this->body = null;
        $this->headers = [
            'Content-Type' => 'text/html'
        ];
    }
    
    public function body($data)
    {
        $this->body = $data;
        return $this;
    }
    
    public function send()
    {
        $this->_setHeaders();
        if($this->asJson) {
            die(json_encode($this->body));
        }
        die($this->body);
    }
    
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }
    
    public function json()
    {
        $this->headers['Content-Type'] = 'application/json;charset=UTF-8';
        $this->asJson = true;
        return $this;
    }
    
    private function _setHeaders()
    {
        foreach($this->headers as $key => $value)
        {
            header("$key:$value", true, 200);
        }
    }
}
