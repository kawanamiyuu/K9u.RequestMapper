<?php

declare(strict_types=1);

namespace K9u\Router\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
final class PatchMapping extends AbstractMapping
{
    public function __construct(array $data)
    {
        parent::__construct($data['value'], 'PATCH');
    }
}
