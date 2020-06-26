<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Symfony\Component\Routing\RouteCollection as HandlerCollection;

interface HandlerCollectorInterface
{
    public function __invoke(): HandlerCollection;
}
