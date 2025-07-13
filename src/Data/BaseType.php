<?php

namespace Mochaka\SerializationParser\Data;

use Mochaka\SerializationParser\Enums\VisibilityEnum;
use Mochaka\SerializationParser\Support\ArrayFactory;
use Mochaka\SerializationParser\Interfaces\TypeInterface;

abstract class BaseType implements TypeInterface
{
    public ?string $name = null;
    public ?VisibilityEnum $visibility = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getVisibility(): ?VisibilityEnum
    {
        return $this->visibility;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setVisibility(VisibilityEnum $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function isType(string $type): bool
    {
        return match ($type) {
            'bool'   => $this->isBool(),
            'string' => $this->isString(),
            'int'    => $this->isInt(),
            'float'  => $this->isFloat(),
            'array'  => $this->isArray(),
            'object' => $this->isObject(),
            'class'  => $this->isClass(),
            'enum'   => $this->isEnum(),
            'null'   => $this->isNull(),
        };
    }

    public function isBool(): bool
    {
        return false;
    }

    public function isString(): bool
    {
        return false;
    }

    public function isInt(): bool
    {
        return false;
    }

    public function isFloat(): bool
    {
        return false;
    }

    public function isArray(): bool
    {
        return false;
    }

    public function isObject(): bool
    {
        return false;
    }

    public function isClass(?string $className = null): bool
    {
        return false;
    }

    public function isEnum(?string $enumClassName = null): bool
    {
        return false;
    }

    public function isNull(): bool
    {
        return false;
    }

    public function toArray(): array
    {
        return ArrayFactory::toArray($this);
    }
}
