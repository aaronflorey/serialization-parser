<?php

namespace Mochaka\SerializationParser;

use InvalidArgumentException;
use Mochaka\SerializationParser\Data\EnumType;
use Mochaka\SerializationParser\Data\NullType;
use Mochaka\SerializationParser\Data\ArrayType;
use Mochaka\SerializationParser\Data\ClassType;
use Mochaka\SerializationParser\Data\FloatType;
use Mochaka\SerializationParser\Data\ObjectType;
use Mochaka\SerializationParser\Data\StringType;
use Mochaka\SerializationParser\Data\BooleanType;
use Mochaka\SerializationParser\Data\IntegerType;
use Mochaka\SerializationParser\Enums\VisibilityEnum;
use Mochaka\SerializationParser\Support\StringReader;
use Mochaka\SerializationParser\Interfaces\TypeInterface;
use Mochaka\SerializationParser\Interfaces\ObjectTypeInterface;

class SerializationParser
{
    public const PROTECTED_PREFIX = "\0*\0";

    public static function parse(string $data): TypeInterface|ObjectTypeInterface
    {
        return (new self())->handle(new StringReader($data));
    }

    public function handle(StringReader $string): TypeInterface|ObjectTypeInterface
    {
        $type = $string->readOne();

        $string->readRequiredChar(':', ';');

        switch ($type) {
            case 'b':
                return new BooleanType(filter_var($string->readUntil(';'), \FILTER_VALIDATE_BOOLEAN));
            case 'i':
                return new IntegerType((int) $string->readUntil(';'));
            case 'd':
                return new FloatType((float) $string->readUntil(';'));
            case 's':
                $len = (int) $string->readUntil(':');
                $val = $string->read($len + 2);
                $string->read(1);

                return new StringType($val);
            case 'N':
                return new NullType();
            case 'E':
                return $this->parseEnum($string);
            case 'a':
                return $this->parseArray($string);
            case 'O':
                return $this->parseObject($string);
            default:
                throw new InvalidArgumentException("Unsupported type: {$type}");
        }
    }

    private function parseArray(StringReader $string): ArrayType
    {
        /** Associative array: a:length:{[index][value]...} */
        $count = (int) $string->readUntil(':');

        // Eat the opening "{" of the array.
        $string->readRequiredChar('{');

        $array = new ArrayType();

        for ($i = 0; $i < $count; ++$i) {
            /** @var IntegerType|StringType $key */
            $key = $this->handle($string);
            $value = $this->handle($string);

            $value->setName((string) $key->getValue());
            $array->addProperty($value);
        }

        // Eat "}" terminating the array.
        $string->readRequiredChar('}');

        return $array;
    }

    private function parseObject(StringReader $string): ObjectType|ClassType
    {
        /** Object: O:length:"class":length:{[property][value]...} */
        $len = (int) $string->readUntil(':');

        // +2 for quotes
        $class = $string->read(2 + $len);

        // Eat the separator
        $string->readRequiredChar(':');

        if ($class === 'stdClass') {
            $object = new ObjectType();
        } else {
            $object = new ClassType($class);
        }

        // Read the number of properties.
        $len = (int) $string->readUntil(':');

        // Eat "{" holding the properties.
        $string->readRequiredChar('{');

        for ($i = 0; $i < $len; ++$i) {
            /** @var IntegerType|StringType $key */
            $key = $this->handle($string);
            $key = (string) $key->getValue();

            $value = $this->handle($string);
            $value->setVisibility(VisibilityEnum::PUBLIC);

            // Strip the protected and private prefixes from the names.
            // Maybe replace them with something more informative, such as "protected:" and "private:"?
            if (substr($key, 0, \strlen(self::PROTECTED_PREFIX)) == self::PROTECTED_PREFIX) {
                $key = substr($key, \strlen(self::PROTECTED_PREFIX));
                $value->setVisibility(VisibilityEnum::PROTECTED);
            }

            if (substr($key, 0, 1) == "\0") {
                [, , $privateKey] = explode("\0", $key);

                $key = $privateKey;
                $value->setVisibility(VisibilityEnum::PRIVATE);
            }

            $value->setName($key);
            $object->addProperty($value);
        }

        // Eat the closing "}" of the object.
        $string->readRequiredChar('}');

        return $object;
    }

    private function parseEnum(StringReader $string): EnumType
    {
        // Object: E:length:"enumClass";
        $len = (int) $string->readUntil(':');

        // +2 for quotes
        [$enum, $value] = explode(':', $string->read(2 + $len));

        // Eat the separator
        $string->readRequiredChar(';');

        return new EnumType($enum, $value);
    }
}
