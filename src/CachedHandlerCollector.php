<?php

declare(strict_types=1);

namespace K9u\Router;

use Symfony\Component\Routing\RouteCollection as HandlerCollection;

final class CachedHandlerCollector implements HandlerCollectorInterface
{
    public function __invoke(): HandlerCollection
    {
        // TODO: to be implemented.
        return new HandlerCollection();
    }
}
