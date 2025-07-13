<?php

namespace Mochaka\SerializationParser\Support;

use UnitEnum;
use BackedEnum;
use ReflectionClass;
use ReflectionMethod;
use Mochaka\SerializationParser\Data\BaseType;
use Mochaka\SerializationParser\Interfaces\TypeInterface;

/**
 * @phpstan-type TArray array{
 *  name: string|null,
 *  type: string,
 *  visibility: 'PROTECTED'|'PUBLIC'|'PRIVATE'|null,
 *  value?: string|int|float|bool|null,
 *  properties?: array<int, array{
 *      name: string|null,
 *      type: string,
 *      visibility: 'PROTECTED'|'PUBLIC'|'PRIVATE'|null,
 *      value?: string|int|float|bool|null,
 *      properties?: array<int, array<string, mixed>>,
 *      enumName?: string,
 *      className?: string,
 *  }>,
 *  enumName?: string,
 *  className?: string,
 * }
 */
class ArrayFactory
{
    /**
     * @return TArray
     */
    public static function toArray(TypeInterface $type): array
    {
        return (new self())->handle($type);
    }

    /**
     * @return TArray
     */
    public function handle(TypeInterface $type): array
    {
        $array = ['type' => $this->getType($type)];

        $rc = new ReflectionClass($type);
        $properties = $rc->getProperties(ReflectionMethod::IS_PUBLIC);

        foreach ($properties as $property) {
            $getter = 'get' . ucwords($property->getName());
            if (method_exists($type, $getter)) {
                $array[$property->getName()] = $this->getPropertyValue($type->{$getter}());
            } else {
                $array[$property->getName()] = $this->getPropertyValue($property->getValue($this));
            }
        }

        ksort($array);

        return $array;
    }

    public function getType(TypeInterface $class): string
    {
        $type = preg_replace('/Type$/', '', $class::class);
        $type = explode('\\', $type);

        return array_pop($type);
    }

    public function getPropertyValue(mixed $value): mixed
    {
        if (\is_array($value)) {
            return array_map(function(mixed $value) {
                return $this->getPropertyValue($value);
            }, $value);
        }

        if (\is_object($value)) {
            if (is_a($value, BaseType::class)) {
                return $this->handle($value);
            }

            if (is_a($value, BackedEnum::class)) {
                return $value->value;
            }

            if (is_a($value, UnitEnum::class)) {
                if (method_exists($value, 'toString')) {
                    return $value->toString();
                }

                return $value->name;
            }
        }

        return $value;
    }
}
