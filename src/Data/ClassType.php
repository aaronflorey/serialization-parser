<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Traits\HasProperties;
use Mochaka\SerializationParser\Interfaces\TypeInterface;
use Mochaka\SerializationParser\Interfaces\ObjectTypeInterface;

class ClassType extends BaseType implements ObjectTypeInterface, TypeInterface
{
    use HasProperties;

    public function __construct(public string $className)
    {
    }

    /**
     * @return class-string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    public function isObject(): bool
    {
        return false;
    }

    public function isClass(?string $className = null): bool
    {
        if (\is_string($className)) {
            return $this->getClassName() === $className;
        }

        return true;
    }
}
