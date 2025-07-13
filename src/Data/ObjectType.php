<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Traits\HasProperties;
use Mochaka\SerializationParser\Interfaces\TypeInterface;
use Mochaka\SerializationParser\Interfaces\ObjectTypeInterface;

class ObjectType extends BaseType implements ObjectTypeInterface, TypeInterface
{
    use HasProperties;

    public function isObject(): bool
    {
        return true;
    }
}
