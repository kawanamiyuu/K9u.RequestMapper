<?php

declare(strict_types=1);

namespace K9u\Router;

use Psr\Http\Message\ServerRequestInterface;
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

        $matched = $matcher->match($path);

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
