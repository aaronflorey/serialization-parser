<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Interfaces\TypeInterface;

class BooleanType extends BaseType implements TypeInterface
{
    public function __construct(
        public bool $value
    )
    {
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function isBool(): bool
    {
        return true;
    }
}
