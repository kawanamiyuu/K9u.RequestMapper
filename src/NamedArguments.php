<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use ArrayAccess;
use BadMethodCallException;
use LogicException;

/**
 * @implements \ArrayAccess<string, mixed>
 */
class NamedArguments implements ArrayAccess
{
    /**
     * @var array<string, mixed>
     */
    private array $args = [];

    /**
     * @param array<string, mixed> $args
     */
    public function __construct(array $args)
    {
        foreach ($args as $offset => $value) {
            if (! (is_string($offset) && strlen($offset) > 0)) {
                throw new LogicException('argument name must be string literal.');
            }

            $this->args[$offset] = $value;
        }
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->args[$offset]);
    }

    /**
     * @param string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->args[$offset];
    }

    /**
     * @param string $offset
     * @param mixed  $value
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
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->args;
    }
}
