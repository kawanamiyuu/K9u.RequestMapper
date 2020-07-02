<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

interface HandlerClassFactoryInterface
{
    public function __invoke(string $class): object;
}
