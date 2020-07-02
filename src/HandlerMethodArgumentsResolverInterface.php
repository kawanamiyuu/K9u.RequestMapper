<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

interface HandlerMethodArgumentsResolverInterface
{
    /**
     * @param ReflectionMethod       $method
     * @param ServerRequestInterface $request
     * @param PathVariables          $pathVariables
     *
     * @return array<mixed>
     */
    public function __invoke(
        ReflectionMethod $method,
        ServerRequestInterface $request,
        PathVariables $pathVariables
    ): array;
}
