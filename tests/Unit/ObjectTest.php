<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Tests\TestCase;
use Mochaka\SerializationParser\Data\ObjectType;

class ObjectTest extends TestCase
{
    public function testItParsesIntoString(): void
    {
        $value = serialize((object) ['test' => 1]);
        $this->assertSerializedReturnsType($value, ObjectType::class);
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize((object) ['test' => 1]));
        $this->assertType($value, 'object');
    }

    public function testItReturnsArray(): void
    {
        $value = (object) [
            'integer' => 1,
            'float'   => 1.0,
            'string'  => 'test',
            'boolean' => true,
            'null'    => null,
            'array'   => [1, 2, 3],
            'object'  => (object) ['test' => 1],
        ];
        $value = $this->parse(serialize($value));

        $this->assertSame([
            'name'       => null,
            'properties' => [
                [
                    'name'       => 'integer',
                    'type'       => 'Integer',
                    'value'      => 1,
                    'visibility' => 'public',
                ],
                [
                    'name'       => 'float',
                    'type'       => 'Float',
                    'value'      => 1.0,
                    'visibility' => 'public',
                ],
                [
                    'name'       => 'string',
                    'type'       => 'String',
                    'value'      => 'test',
                    'visibility' => 'public',
                ],
                [
                    'name'       => 'boolean',
                    'type'       => 'Boolean',
                    'value'      => true,
                    'visibility' => 'public',
                ],
                [
                    'name'       => 'null',
                    'type'       => 'Null',
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
                [
                    'name'       => 'object',
                    'properties' => [
                        [
                            'name'       => 'test',
                            'type'       => 'Integer',
                            'value'      => 1,
                            'visibility' => 'public',
                        ],
                    ],
                    'type'       => 'Object',
                    'visibility' => 'public',
                ],
            ],
            'type'       => 'Object',
            'visibility' => null,
        ], $value->toArray());
    }
}
