<?php

declare(strict_types=1);

namespace K9u\Router\Annotation;

use Symfony\Component\Routing\Annotation\Route;

abstract class AbstractMapping
{
    /**
     * @var Route
     */
    private $delegate;

    public function __construct(string $path, ?string $method)
    {
        $methods = $method ? [$method] : [];

        $this->delegate = new Route([
            'value' => $path,
            'methods' => $methods
        ]);
    }

    public function __call(string $name, array $arguments)
    {
        return $this->delegate->{$name}($arguments);
    }
}
