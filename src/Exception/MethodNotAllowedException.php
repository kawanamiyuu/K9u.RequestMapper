<?php

declare(strict_types=1);

namespace K9u\Router\Exception;

use Throwable;

final class MethodNotAllowedException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(string $method, string $path, Throwable $previous = null)
    {
        parent::__construct("Method Not Allowed: {$method} {$path}", 0, $previous);
    }
}
