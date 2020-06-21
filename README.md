# K9u.Router

[![badge](https://github.com/kawanamiyuu/K9u.Router/workflows/CI/badge.svg)](https://github.com/kawanamiyuu/K9u.Router/actions?query=workflow%3ACI)

Annotatable Router library for PHP.

## Usage

```php
use Vendor\Package\Presentation\Blog;

class BlogController
{
    /**
     * @GetMapping("/blogs/{id}")
     */
    public function show($id)
    {
        // snip
    }
}
```

```php
use K9u\Router;

$request = ServerRequestFactory::createServerRequest('GET', '/blogs/1', $_SERVER);

$router = new Router(new OnDemandRouteCollector('/path/to/src/Presentation'));
$handler = $router->match($request);

var_dump([
    'class' => $handler->class,
    'method' => $handler->method,
    'variables' => $handler->variables,
]);
```

```
array(3) {
  ["class"]=>
  string(34) "Vendor\Package\Presentation\Blog\BlogController"
  ["method"]=>
  string(3) "show"
  ["variables"]=>
  array(1) {
    ["id"]=>
    string(1) "1"
  }
}
```
