<?php
// Classes
require_once 'Http/HttpRequest.php';
require_once 'Http/HttpResponse.php';
require_once 'Db/DbConnection.php';
// Configs
require '../Config/routes.php';
require '../Config/database.php';

class Application
{
    /** @var HttpRequest */
    private $request;
    /** @var HttpResponse */
    private $response;
    /** @var array */
    private $routes = [];
    /** @var array */
    private $databasesConfig = [];

    public function __construct()
    {
        global $routes, $databases;

        $this->request         = new HttpRequest();
        $this->response        = new HttpResponse();
        $this->routes          = $routes;
        $this->databasesConfig = $databases;

        // Unset Globals
        unset($route, $databases);

        if( count($this->databasesConfig) )
        {
            // Init Database Connections
            foreach($this->databasesConfig as $name => $options)
            {
                DbConnection::create($name, $options);
            }
        }
    }

    public function run()
    {
        $routePath = $this->request->getRoutePath();
        $route     = ArrayHelper::getValue($this->routes, $routePath);
        if ($route)
        {
            if (is_callable($route))
                $response = call_user_func_array($route, [ $this->request, $this->response, $this ]);
            else
                $response = $this->response;

            if ($response instanceof HttpResponse)
                $response->send();
        }
        $this->response->body("$routePath Not Found")->send();
    }

    public function getDb($name = 'db')
    {
        return DbConnection::getInstance($name);
    }
}
