<?php

declare(strict_types=1);

namespace K9u\RequestMapper\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class RequestMapping extends AbstractMapping
{
    /**
     * @param array<string, string> $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data['value'], null);
    }
}
