<?php

namespace Mochaka\SerializationParser\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Mochaka\SerializationParser\SerializationParser;
use Mochaka\SerializationParser\Interfaces\TypeInterface;
use Mochaka\SerializationParser\Interfaces\ObjectTypeInterface;

class TestCase extends Orchestra
{
    public function parse(string $serializedData): TypeInterface|ObjectTypeInterface
    {
        return SerializationParser::parse($serializedData);
    }

    public function assertSerializedReturnsType(string $serializedData, string $expectedClass): void
    {
        $value = $this->parse($serializedData);

        $this->assertInstanceOf($expectedClass, $value);
    }

    public function assertReturnsCorrectValue(mixed $unserializedData): void
    {
        $value = $this->parse(serialize($unserializedData));
        $this->assertSame($unserializedData, $value->getValue());
    }

    /**
     * @param 'array'|'bool'|'class'|'enum'|'float'|'int'|'null'|'object'|'string' $type
     */
    public function assertType(TypeInterface $object, string $type): void
    {
        $types = ['bool', 'string', 'int', 'float', 'array', 'object', 'class', 'enum', 'null'];
        foreach ($types as $t) {
            if ($t === $type) {
                $this->assertTrue($object->isType($t), 'Expected type: ' . $t);
            } else {
                $this->assertFalse($object->isType($t), 'Unexpected type: ' . $t);
            }
        }
    }
}
