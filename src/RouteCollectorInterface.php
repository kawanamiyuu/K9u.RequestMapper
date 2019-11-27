<?php

declare(strict_types=1);

namespace K9u\Router;

use Symfony\Component\Routing\RouteCollection;

interface RouteCollectorInterface
{
    public function __invoke(): RouteCollection;
}
