<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

final class Handler
{
    public string $class;

    public string $method;

    public PathVariables $pathVariables;

    /**
     * @param string                $class
     * @param string                $method
     * @param array<string, string> $pathVariables
     */
    public function __construct(string $class, string $method, array $pathVariables)
    {
        $this->class = $class;
        $this->method = $method;
        $this->pathVariables = new PathVariables($pathVariables);
    }
}
