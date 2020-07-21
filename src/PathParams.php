<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use LogicException;

/**
 * @implements \ArrayAccess<string, string>
 */
class PathParams implements ArrayAccess
{
    /**
     * @var array<string, string>
     */
    private array $params = [];

    /**
     * @param array<string, string> $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $offset => $value) {
            if (! (is_string($offset) && strlen($offset) > 0)) {
                throw new LogicException('param name must be string literal.');
            }

            $this->params[$offset] = $value;
        }
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->params[$offset]);
    }

    /**
     * @param string $offset
     *
     * @return string|null
     */
    public function offsetGet($offset): ?string
    {
        return $this->params[$offset];
    }

    /**
     * @param string $offset
     * @param string $value
     */
    public function offsetSet($offset, $value): void
    {
        unset($offset, $value); // unused

        throw new BadMethodCallException('unsupported');
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        unset($offset); // unused

        throw new BadMethodCallException('unsupported');
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->params;
    }
}
