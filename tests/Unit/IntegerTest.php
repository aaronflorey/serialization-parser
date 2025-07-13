<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Tests\TestCase;
use Mochaka\SerializationParser\Data\IntegerType;

class IntegerTest extends TestCase
{
    public function testItParsesIntoInteger(): void
    {
        $value = serialize(14159);
        $this->assertSerializedReturnsType($value, IntegerType::class);
    }

    public function testItHasCorrectValue(): void
    {
        $this->assertReturnsCorrectValue(14159);
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize(14159));
        $this->assertType($value, 'int');
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize(14159));

        $this->assertSame([
            'name'       => null,
            'type'       => 'Integer',
            'value'      => 14159,
            'visibility' => null,
        ], $value->toArray());
    }
}
