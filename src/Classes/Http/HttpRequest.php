<?php
require_once '../Helpers/ArrayHelper.php';

class HttpRequest
{
    private $request;
    private $server;
    private $query;
    
    public function __construct()
    {
        $this->request = $_POST;
        $this->query   = $_GET;
        $this->server  = $_SERVER;
    }
    
    public function get($key = null)
    {
        if($key !== null)
            return ArrayHelper::getValue($this->query, $key);
        
        return $this->query;
    }
    
    public function post($key = null)
    {
        if($key !== null)
            return ArrayHelper::getValue($this->request, $key);
        
        return $this->request;
    }
    
    public function method()
    {
        return ArrayHelper::getValue($this->server, 'METHOD');
    }
    
    public function jsonBody()
    {
        $payload = file_get_contents('php://input');
        return json_decode($payload);
    }
    
    public function getServer()
    {
        return $this->server;
    }
    
    public function getRoutePath()
    {
        $scriptName = ArrayHelper::getValue($this->server, 'SCRIPT_NAME');
        $uri = ArrayHelper::getValue($this->server, 'REQUEST_URI');
        $path = str_replace($scriptName, '', $uri);
        $p = explode('?', $path, 2);
        $path = $p[0];
        if($path == '') return '/';
        return $path;
    }
}
