<?php
// Classes
require_once 'Http/HttpRequest.php';
require_once 'Http/HttpResponse.php';
require_once 'Db/DbConnection.php';
require_once 'Router.php';
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
    private $routesConfig = [];
    /** @var array */
    private $databasesConfig = [];

    public function __construct()
    {
        global $routes, $databases;

        $this->request         = new HttpRequest();
        $this->response        = new HttpResponse();
        $this->routesConfig    = $routes;
        $this->databasesConfig = $databases;

        // Unset Globals
        unset($route, $databases);

        // Routes Initialize
        Router::init($this->routesConfig);
        // Databases Initialize
        DbConnection::init($this->databasesConfig);
    }

    public function run()
    {
        $route = Router::getRouteByRequest($this->request);
        if ($route)
        {
            $response = $route->execute($this->request, $this->response, $this);
            if ($response instanceof HttpResponse)
                $response->send();
        }
        $this->response->body($route->path()." Not Found")->send();
    }

    public function getDb($name = 'db')
    {
        return DbConnection::getInstance($name);
    }
}
