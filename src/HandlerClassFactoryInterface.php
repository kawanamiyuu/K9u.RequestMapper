<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

interface HandlerClassFactoryInterface
{
    /**
     * @param string $class FQCN of handler class
     *
     * @return object handler class instance
     */
    public function __invoke(string $class): object;
}
