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
        assert(class_exists($handler->class));
        assert(method_exists($handler->class, $handler->method));

        $obj = ($this->classFactory)($handler->class);
        $method = new ReflectionMethod($handler->class, $handler->method);
        $args = ($this->methodArgsResolver)($method, $request, $handler->pathVariables);

        return $method->invokeArgs($obj, $args);
    }
}
