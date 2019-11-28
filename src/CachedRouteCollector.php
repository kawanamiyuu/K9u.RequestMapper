<?php

declare(strict_types=1);

namespace K9u\Router;

use Symfony\Component\Routing\RouteCollection;

final class CachedRouteCollector implements RouteCollectorInterface
{
    public function __invoke(): RouteCollection
    {
        // TODO: Implement __invoke() method.
        return new RouteCollection();
    }
}
