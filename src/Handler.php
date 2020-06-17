<?php

declare(strict_types=1);

namespace K9u\Router;

final class Handler
{
    public string $class;

    public string $method;

    /**
     * @var array<string, string>
     */
    public array $variables;

    /**
     * @param string                $class
     * @param string                $method
     * @param array<string, string> $variables
     */
    public function __construct(string $class, string $method, array $variables)
    {
        $this->class = $class;
        $this->method = $method;
        $this->variables = $variables;
    }
}
