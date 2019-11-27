<?php

declare(strict_types=1);

namespace K9u\Router\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Handler extends AbstractRoute
{
    public function __construct(array $data)
    {
        parent::__construct($data['value'], null);
    }
}
