<?php

declare(strict_types=1);

namespace K9u\Router\Annotation;

use Symfony\Component\Routing\Annotation\Route;

abstract class AbstractMapping
{
    private Route $delegate;

    protected function __construct(string $path, ?string $method)
    {
        $methods = $method ? [$method] : [];

        $this->delegate = new Route([
            'value' => $path,
            'methods' => $methods
        ]);
    }

    /**
     * @param string  $name
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->delegate->{$name}(...$arguments);
    }
}
