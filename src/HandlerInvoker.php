<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

class HandlerInvoker implements HandlerInvokerInterface
{
    private HandlerClassFactoryInterface $classFactory;

    private HandlerMethodArgumentsResolverInterface $methodArgsResolver;

    public function __construct(
        HandlerClassFactoryInterface $classFactory,
        HandlerMethodArgumentsResolverInterface $methodArgsResolver
    ) {
        $this->classFactory = $classFactory;
        $this->methodArgsResolver = $methodArgsResolver;
    }

    public function __invoke(Handler $handler, ServerRequestInterface $request)
    {
        $obj = ($this->classFactory)($handler->class);
        $method = new ReflectionMethod($obj, $handler->method);
        $args = ($this->methodArgsResolver)($method, $request, $handler->pathParams);

        return $method->invokeArgs($obj, $args->toArray());
    }
}
