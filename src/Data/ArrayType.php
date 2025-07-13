<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Traits\HasProperties;
use Mochaka\SerializationParser\Interfaces\TypeInterface;
use Mochaka\SerializationParser\Interfaces\ObjectTypeInterface;

class ArrayType extends BaseType implements ObjectTypeInterface, TypeInterface
{
    use HasProperties;

    public function isObject(): bool
    {
        return false;
    }

    public function isArray(): bool
    {
        return true;
    }
}
