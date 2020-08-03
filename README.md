# K9u.RequestMapper

[![badge](https://github.com/kawanamiyuu/K9u.RequestMapper/workflows/CI/badge.svg)](https://github.com/kawanamiyuu/K9u.RequestMapper/actions?query=workflow%3ACI)

Annotatable Request Mapper library for PHP.

## Usage

```php
use K9u\RequestMapper\Annotation\GetMapping;
use My\App\Presentation\Blog;

class BlogController
{
    /**
     * @GetMapping("/blogs/{id}")
     */
    public function show($id)
    {
        // snip(find blog by $id)
        $blog = [
            'id' => $id,
            'title' => 'Hello world!',
            ...
        ];

        return $blog;
    }
}
```

```php
use K9u\RequestMapper;

$request = $serverRequestFactory->createServerRequest('GET', 'http://example.com/blogs/1', $_SERVER);

$handlerResolver = new HandlerResolver('/path/to/src/Presentation');
$handler = $handlerResolver($request);

// $handler->class      = 'My\App\Presentation\Blog\BlogController'
// $handler->method     = 'show'
// $handler->pathParams = ['id' => '1']

$handlerClassFactory = ...;
/* @var HandlerClassFactoryInterface $handlerClassFactory */

$handlerMethodArgumentsResolver = ...;
/* @var HandlerMethodArgumentsResolverInterface $handlerMethodArgumentsResolver */

$handlerInvoker = new HandlerInvoker($handlerClassFactory, $handlerMethodArgumentsResolver);
$result = $handlerInvoker($handler, $request);

var_export($result);
// array (
//   'id' => 1,
//   'title' => 'Hello world!',
//   ...
// )
```
