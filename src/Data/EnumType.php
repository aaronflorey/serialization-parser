<?php

namespace Mochaka\SerializationParser\Data;

use UnitEnum;
use Mochaka\SerializationParser\Interfaces\TypeInterface;

class EnumType extends BaseType implements TypeInterface
{
    public function __construct(public string $enumName, public string $value)
    {
    }

    /**
     * @return class-string<UnitEnum>
     */
    public function getEnumName(): string
    {
        return $this->enumName;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEnum(?string $enumClassName = null): bool
    {
        if (\is_string($enumClassName)) {
            return $this->getEnumName() === $enumClassName;
        }

        return true;
    }
}
