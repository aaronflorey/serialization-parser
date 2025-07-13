<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Tests\TestCase;
use Mochaka\SerializationParser\Data\StringType;

class StringTest extends TestCase
{
    public function testItParsesIntoString(): void
    {
        $value = serialize('this is a test');
        $this->assertSerializedReturnsType($value, StringType::class);
    }

    public function testItHasCorrectValue(): void
    {
        $this->assertReturnsCorrectValue('this is a test');
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize('this is a test'));
        $this->assertType($value, 'string');
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize('this is a test'));

        $this->assertSame([
            'name'       => null,
            'type'       => 'String',
            'value'      => 'this is a test',
            'visibility' => null,
        ], $value->toArray());
    }
}
