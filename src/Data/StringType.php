<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Interfaces\TypeInterface;

class StringType extends BaseType implements TypeInterface
{
    public function __construct(public string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isString(): bool
    {
        return true;
    }
}
