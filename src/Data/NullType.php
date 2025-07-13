<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Interfaces\TypeInterface;

class NullType extends BaseType implements TypeInterface
{
    public function isNull(): bool
    {
        return true;
    }
}
