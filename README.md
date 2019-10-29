
# Micro Script Framework

This is a micro php framework to help you write php scripts in a OOP way and merge all required files in a single php file.

### Install
```bash
$ composer install
```

### Build
```bash
$ composer build
```


### Compiled Example

```php
<?php class ArrayHelper{...};class HttpRequest{...};class HttpResponse{...};$routes = array('/' => function (HttpRequest $req, HttpResponse $res) {$hello = $req->get('hello');$json = $req->get('json');if (!empty($hello)) {$res->body("Hello {$hello}");if ($json) {$res->json();}}return $res;});;class Application{...};(new Application())->run(); ?>
```
