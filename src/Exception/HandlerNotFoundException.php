<?php

declare(strict_types=1);

namespace K9u\RequestMapper\Exception;

use RuntimeException;
use Throwable;

final class HandlerNotFoundException extends RuntimeException implements ExceptionInterface
{
    public function __construct(string $method, string $path, Throwable $previous = null)
    {
        parent::__construct("Handler Not Found: {$method} {$path}", 0, $previous);
    }
}
