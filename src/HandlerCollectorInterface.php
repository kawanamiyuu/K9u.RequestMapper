<?php

declare(strict_types=1);

namespace K9u\Router;

use Symfony\Component\Routing\RouteCollection as HandlerCollection;

interface HandlerCollectorInterface
{
    public function __invoke(): HandlerCollection;
}
