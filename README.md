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

// $handler->class         = 'Vendor\Package\Presentation\Blog\BlogController'
// $handler->method        = 'show'
// $handler->pathVariables = ['id' => '1']

$handlerClassFactory = ...;
/* @var HandlerClassFactoryInterface $handlerClassFactory */

$handlerMethodArgumentsResolver = ...;
/* @var HandlerMethodArgumentsResolverInterface $handlerMethodArgumentsResolver */

$handlerInvoker = new HandlerInvoker($handlerClassFactory, $handlerMethodArgumentsResolver);
$result = $handlerInvoker($handler, $request);
```
