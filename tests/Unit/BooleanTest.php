<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Tests\TestCase;
use Mochaka\SerializationParser\Data\BooleanType;

class BooleanTest extends TestCase
{
    public function testItParsesIntoBoolean(): void
    {
        $value = serialize(true);
        $this->assertSerializedReturnsType($value, BooleanType::class);
    }

    public function testItHasCorrectValue(): void
    {
        $this->assertReturnsCorrectValue(true);
        $this->assertReturnsCorrectValue(false);
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize(true));

        $this->assertSame([
            'name'       => null,
            'type'       => 'Boolean',
            'value'      => true,
            'visibility' => null,
        ], $value->toArray());
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize(true));
        $this->assertType($value, 'bool');
    }
}
