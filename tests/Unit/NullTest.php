<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Data\NullType;
use Mochaka\SerializationParser\Tests\TestCase;

class NullTest extends TestCase
{
    public function testItParsesIntoString(): void
    {
        $value = serialize(null);
        $this->assertSerializedReturnsType($value, NullType::class);
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize(null));
        $this->assertType($value, 'null');
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize(null));

        $this->assertSame([
            'name'       => null,
            'type'       => 'Null',
            'visibility' => null,
        ], $value->toArray());
    }
}
