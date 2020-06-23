<?php

declare(strict_types=1);

namespace K9u\Router;

use K9u\Router\Exception\HandlerNotFoundException;
use K9u\Router\Exception\MethodNotAllowedException;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException as MethodNotAllowed;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as HandlerNotFound;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection as HandlerCollection;

class Router
{
    private HandlerCollectorInterface $handlerCollector;

    private HandlerCollection $handlerCollection;

    public function __construct(HandlerCollectorInterface $handlerCollector)
    {
        $this->handlerCollector = $handlerCollector;
    }

    public function match(ServerRequestInterface $request): Handler
    {
        if (! isset($this->handlerCollection)) {
            $this->handlerCollection = ($this->handlerCollector)();
        }

        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $context = new RequestContext('/', $method);
        $matcher = new UrlMatcher($this->handlerCollection, $context);

        try {
            $matched = $matcher->match($path);
        } catch (HandlerNotFound $e) {
            throw new HandlerNotFoundException($method, $path, $e);
        } catch (MethodNotAllowed $e) {
            throw new MethodNotAllowedException($method, $path, $e);
        }

        return new Handler(
            AnnotatedHandlerClassLoader::extractHandlerClass($matched),
            AnnotatedHandlerClassLoader::extractHandlerMethod($matched),
            AnnotatedHandlerClassLoader::extractPathVariables($matched)
        );
    }
}
