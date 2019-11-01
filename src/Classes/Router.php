<?php
require_once 'Http/HttpRoute.php';

class Router
{
    /** @var HttpRoute[] */
    private static $routes;

    /**
     * Initialize Component
     * @param $routesConfig
     */
    public static function init($routesConfig)
    {
        if (count($routesConfig))
            foreach ($routesConfig as $path => $config)
                self::createRoute($path, $config);
    }

    /**
     * Create Route
     * @param $path
     * @param $routeConfig
     */
    public static function createRoute($path, $routeConfig)
    {
        if(!is_string($path))
            throw new InvalidArgumentException("Path must be string");

        if (is_callable($routeConfig))
        {
            self::$routes[] = new HttpRoute([
                'path'     => $path,
                'callable' => $routeConfig,
            ]);
        } elseif (is_array($routeConfig))
        {
            self::$routes[] = new HttpRoute(
                array_merge($routeConfig, [ 'path' => $path ])
            );
        }
    }

    /**
     * Find Route From Request
     * @param HttpRequest $request
     * @return HttpRoute|null
     */
    public static function getRouteByRequest(HttpRequest $request)
    {
        $routePath = $request->getRoutePath();
        $route     = null;
        foreach (self::$routes as $_route)
        {
            if ($_route->match($routePath))
            {
                $route = $_route;
                break;
            }
        }
        return $route;
    }
}