<?php
$routes = [

    // Index
    '/' => [

        'middlewares' => [
            // Middleware 1
            function(HttpRequest $req, HttpResponse $res, Application $app) {
                if(!$req->get('hello'))
                {
                    $res->json()->body([
                        'success' => false,
                        'msg' => 'Invalid format'
                    ])->send();
                }
                $req->helloValue = $req->get('hello');
            },
            // Middleware 2
            function(HttpRequest $req, HttpResponse $res, Application $app) {
                $res
                    ->setHeader('X-API', 'Micro PHP Framework')
                    ->setHeader('X-HELLO', $req->helloValue);
            },
        ],

        // Core
        'callable' => function (HttpRequest $req, HttpResponse $res, Application $app) {
            return $res->body('Hello There...' . $req->helloValue);
        }
    ]

];
