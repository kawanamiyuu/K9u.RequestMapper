<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

final class Handler
{
    public string $class;

    public string $method;

    public PathParams $pathParams;

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
}
