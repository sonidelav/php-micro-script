<?php
require_once 'Http/HttpRequest.php';
require_once 'Http/HttpResponse.php';
require '../Config/routes.php';

class Application
{
    /** @var HttpRequest */
    private $request;
    /** @var HttpResponse */
    private $response;
    /** @var array */
    private $routes = [];
    
    public function __construct()
    {
        global $routes;
        
        $this->request = new HttpRequest();
        $this->response = new HttpResponse();
        $this->routes = $routes;
    }
    
    public function run()
    {
        $routePath = $this->request->getRoutePath();
        $route = ArrayHelper::getValue($this->routes, $routePath);
        if($route)
        {
            if(is_callable($route))
                $response = call_user_func_array($route, [$this->request, $this->response]);
            
            if($response instanceof HttpResponse)
                $response->send();
        }
        $this->response->body("$routePath Not Found")->send();
    }
}
