<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use IteratorAggregate;
use Traversable;

/**
 * @implements \ArrayAccess<string, string>
 * @implements \IteratorAggregate<string, string>
 */
class PathParams implements ArrayAccess, IteratorAggregate
{
    /**
     * @var array<string, string>
     */
    private array $params;

    /**
     * @param array<string, string> $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
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

        throw new BadMethodCallException('PathParams is immutable.');
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        unset($offset); // unused

        throw new BadMethodCallException('PathParams is immutable.');
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->params);
    }
}
