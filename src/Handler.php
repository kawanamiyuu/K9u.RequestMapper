<?php

declare(strict_types=1);

namespace K9u\Router;

final class Handler
{
    /**
     * @var string
     */
    public $class;

    /**
     * @var string
     */
    public $method;

    /**
     * @var array<string, string>
     */
    public $variables;

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
