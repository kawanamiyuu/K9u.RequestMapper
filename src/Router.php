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

class Router
{
    /**
     * @var RouteCollectorInterface
     */
    private $collector;

    public function __construct(RouteCollectorInterface $collector)
    {
        $this->collector = $collector;
    }

    public function match(ServerRequestInterface $request): Handler
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $context = new RequestContext('/', $method);
        $matcher = new UrlMatcher(($this->collector)(), $context);

        try {
            $matched = $matcher->match($path);
        } catch (HandlerNotFound $e) {
            throw new HandlerNotFoundException($method, $path, $e);
        } catch (MethodNotAllowed $e) {
            throw new MethodNotAllowedException($method, $path, $e);
        }

        return new Handler(
            $matched['_handler_class'],
            $matched['_handler_method'],
            $this->extractVariables($matched)
        );
    }

    private function extractVariables(array $matched)
    {
        return array_filter($matched, function ($key) {
            return substr($key, 0, 1) !== '_';
        }, ARRAY_FILTER_USE_KEY);
    }
}
