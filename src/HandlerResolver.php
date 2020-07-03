<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException as MethodNotAllowed;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as HandlerNotFound;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection as HandlerCollection;

class HandlerResolver implements HandlerResolverInterface
{
    private HandlerCollectorInterface $handlerCollector;

    private HandlerCollection $handlerCollection;

    public function __construct(HandlerCollectorInterface $handlerCollector)
    {
        $this->handlerCollector = $handlerCollector;
    }

    public function __invoke(ServerRequestInterface $request): Handler
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

        $pathParams = array_filter($matched, function ($key) {
            return substr($key, 0, 1) !== '_';
        }, ARRAY_FILTER_USE_KEY);

        return new Handler(
            $matched['_handler_class'],
            $matched['_handler_method'],
            $pathParams
        );
    }
}
