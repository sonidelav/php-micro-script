<?php
require_once '../Helpers/ArrayHelper.php';

class HttpRoute
{
    private $path;
    private $middlewares = [];
    private $callable;

    public function __construct($config)
    {
        $this->path        = ArrayHelper::getValue($config, 'path', null);
        $this->middlewares = ArrayHelper::getValue($config, 'middlewares', []);
        $this->callable    = ArrayHelper::getValue($config, 'callable', null);
    }

    /**
     * Match by URL Path
     * @param $path
     * @return bool
     */
    public function match($path)
    {
        return $path == $this->path;
    }

    /**
     * Route Path
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Execute
     * @param HttpRequest $req
     * @param HttpResponse $res
     * @param Application $app
     * @return mixed|HttpResponse
     */
    public function execute(HttpRequest $req, HttpResponse $res, Application $app)
    {
        // If Middleware Execute them
        if(count($this->middlewares))
        {
            array_reduce($this->middlewares, function($carry, $current) use ($req, $res, $app) {
                return $current($req, $res, $app);
            });
        }

        // Run Callable
        return call_user_func_array($this->callable, [ $req, $res, $app ]);
    }
}