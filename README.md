# K9u.RequestMapper

[![badge](https://github.com/kawanamiyuu/K9u.RequestMapper/workflows/CI/badge.svg)](https://github.com/kawanamiyuu/K9u.RequestMapper/actions?query=workflow%3ACI)

Annotatable Request Mapper library for PHP.

## Usage

```php
use K9u\RequestMapper\Annotation\GetMapping;
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
use K9u\RequestMapper;

$request = ServerRequestFactory::createServerRequest('GET', 'http://example.com/blogs/1', $_SERVER);

$handlerResolver = new HandlerResolver(new OnDemandHandlerCollector('/path/to/src/Presentation'));
$handler = $handlerResolver($request);

var_dump([
    'class' => $handler->class,
    'method' => $handler->method,
    'pathVariables' => $handler->pathVariables,
]);
```

```
array(3) {
  ["class"]=>
  string(34) "Vendor\Package\Presentation\Blog\BlogController"
  ["method"]=>
  string(3) "show"
  ["pathVariables"]=>
  array(1) {
    ["id"]=>
    string(1) "1"
  }
}
```
