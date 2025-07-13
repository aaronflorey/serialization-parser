<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Interfaces\TypeInterface;

class FloatType extends BaseType implements TypeInterface
{
    public function __construct(public float $value)
    {
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function isFloat(): bool
    {
        return true;
    }
}
