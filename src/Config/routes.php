<?php
$routes = [

    // Index
    '/' => function (HttpRequest $req, HttpResponse $res, Application $app) {
        return $res->body('Hello There...');
    },

];
