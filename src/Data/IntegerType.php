<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Interfaces\TypeInterface;

class IntegerType extends BaseType implements TypeInterface
{
    public function __construct(public int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isInt(): bool
    {
        return true;
    }
}
