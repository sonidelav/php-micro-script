<?php
$routes = [
    
    // Index
    '/' => function(HttpRequest $req, HttpResponse $res) {
        $hello = $req->get('hello');
        $json = $req->get('json');
        if( !empty($hello) )
        {
            // Set Body Content
            $res->body("Hello $hello");
            
            // Set JSON Response
            if($json) $res->json();
        }
        return $res;
    }
    
];
