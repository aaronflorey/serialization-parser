<?php

namespace Mochaka\SerializationParser\Interfaces;

use UnitEnum;
use BackedEnum;
use Mochaka\SerializationParser\Enums\VisibilityEnum;
use Mochaka\SerializationParser\Support\ArrayFactory;

/**
 * @phpstan-import-type TArray from ArrayFactory
 */
interface TypeInterface
{
    public function getName(): ?string;

    public function getVisibility(): ?VisibilityEnum;

    public function setName(string $name): static;

    public function setVisibility(VisibilityEnum $visibility): static;

    /**
     * @param 'array'|'bool'|'class'|'enum'|'float'|'int'|'null'|'object'|'string' $type
     */
    public function isType(string $type): bool;

    public function isBool(): bool;

    public function isString(): bool;

    public function isInt(): bool;

    public function isFloat(): bool;

    public function isArray(): bool;

    public function isNull(): bool;

    public function isObject(): bool;

    /**
     * Checks if the type is an enum. If $className is provided, it checks if the type is that specific enum.
     * @param null|class-string<BackedEnum|UnitEnum> $enumClassName
     */
    public function isEnum(?string $enumClassName = null): bool;

    /**
     * Checks if the type is a class. If $className is provided, it checks if the type is that specific class.
     * @param null|class-string $className
     */
    public function isClass(?string $className = null): bool;

    /**
     * @return TArray
     */
    public function toArray(): array;
}
