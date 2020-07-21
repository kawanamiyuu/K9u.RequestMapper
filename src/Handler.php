<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

final class Handler
{
    private string $class;

    private string $method;

    private PathParams $pathParams;

    /**
     * @param string                $class
     * @param string                $method
     * @param array<string, string> $pathParams
     */
    public function __construct(string $class, string $method, array $pathParams)
    {
        assert(class_exists($class));
        assert(method_exists($class, $method));

        $this->class = $class;
        $this->method = $method;
        $this->pathParams = new PathParams($pathParams);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPathParams(): PathParams
    {
        return $this->pathParams;
    }
}
