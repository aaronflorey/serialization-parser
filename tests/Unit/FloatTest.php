<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Data\FloatType;
use Mochaka\SerializationParser\Tests\TestCase;

class FloatTest extends TestCase
{
    public function testItParsesIntoFloat(): void
    {
        $value = serialize(3.14159);
        $this->assertSerializedReturnsType($value, FloatType::class);
    }

    public function testItHasCorrectValue(): void
    {
        $this->assertReturnsCorrectValue(3.14159);
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize(3.14159));
        $this->assertType($value, 'float');
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize(3.14159));

        $this->assertSame([
            'name'       => null,
            'type'       => 'Float',
            'value'      => 3.14159,
            'visibility' => null,
        ], $value->toArray());
    }
}
