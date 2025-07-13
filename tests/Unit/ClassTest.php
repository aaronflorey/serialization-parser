<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Data\ClassType;
use Mochaka\SerializationParser\Tests\TestCase;
use Mochaka\SerializationParser\Enums\VisibilityEnum;
use Mochaka\SerializationParser\Tests\Fixtures\TestClass;

class ClassTest extends TestCase
{
    public function testItParsesIntoString(): void
    {
        $value = serialize(new TestClass());
        $this->assertSerializedReturnsType($value, ClassType::class);
    }

    public function testItChecksClassName(): void
    {
        $classType = $this->parse(serialize(new TestClass()));

        $this->assertTrue($classType->isClass());
        $this->assertTrue($classType->isClass(TestClass::class));
        $this->assertFalse($classType->isClass(ClassTest::class));
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize(new TestClass()));
        $this->assertType($value, 'class');
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize(new TestClass()));

        $this->assertSame([
            'className'  => 'Mochaka\SerializationParser\Tests\Fixtures\TestClass',
            'name'       => null,
            'properties' => [
                [
                    'name'       => 'int',
                    'type'       => 'Integer',
                    'value'      => 1,
                    'visibility' => 'public',
                ],
                [
                    'name'       => 'string',
                    'type'       => 'String',
                    'value'      => 'string',
                    'visibility' => 'public',
                ],
                [
                    'enumName'   => VisibilityEnum::class,
                    'name'       => 'enum',
                    'type'       => 'Enum',
                    'value'      => 'PUBLIC',
                    'visibility' => 'public',
                ],
                [
                    'name'       => 'bool',
                    'type'       => 'Boolean',
                    'value'      => true,
                    'visibility' => 'private',
                ],
                [
                    'name'       => 'float',
                    'type'       => 'Float',
                    'value'      => 1.1,
                    'visibility' => 'private',
                ],
                [
                    'name'       => 'array',
                    'properties' => [
                        [
                            'name'       => '0',
                            'type'       => 'Integer',
                            'value'      => 1,
                            'visibility' => null,
                        ],
                        [
                            'name'       => '1',
                            'type'       => 'Integer',
                            'value'      => 2,
                            'visibility' => null,
                        ],
                        [
                            'name'       => '2',
                            'type'       => 'Integer',
                            'value'      => 3,
                            'visibility' => null,
                        ],
                    ],
                    'type'       => 'Array',
                    'visibility' => 'protected',
                ],
                [
                    'name'       => 'object',
                    'properties' => [
                        [
                            'name'       => 'int',
                            'type'       => 'Integer',
                            'value'      => 1,
                            'visibility' => 'public',
                        ],
                        [
                            'name'       => 'array',
                            'properties' => [
                                [
                                    'name'       => '0',
                                    'type'       => 'Integer',
                                    'value'      => 1,
                                    'visibility' => null,
                                ],
                                [
                                    'name'       => '1',
                                    'type'       => 'Integer',
                                    'value'      => 2,
                                    'visibility' => null,
                                ],
                                [
                                    'name'       => '2',
                                    'type'       => 'Integer',
                                    'value'      => 3,
                                    'visibility' => null,
                                ],
                            ],
                            'type'       => 'Array',
                            'visibility' => 'public',
                        ],
                    ],
                    'type'       => 'Object',
                    'visibility' => 'protected',
                ],
                [
                    'name'       => 'null',
                    'type'       => 'Null',
                    'visibility' => 'protected',
                ],
            ],
            'type'       => 'Class',
            'visibility' => null,
        ], $value->toArray());
    }
}
