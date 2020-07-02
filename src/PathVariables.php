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
class PathVariables implements ArrayAccess, IteratorAggregate
{
    /**
     * @var array<string, string>
     */
    private array $variables;

    /**
     * @param array<string, string> $variables
     */
    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->variables[$offset]);
    }

    /**
     * @param string $offset
     *
     * @return string|null
     */
    public function offsetGet($offset): ?string
    {
        return $this->variables[$offset];
    }

    /**
     * @param string $offset
     * @param string $value
     */
    public function offsetSet($offset, $value): void
    {
        unset($offset, $value); // unused

        throw new BadMethodCallException('PathVariables is immutable.');
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        unset($offset); // unused

        throw new BadMethodCallException('PathVariables is immutable.');
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->variables);
    }
}
