<?php

namespace Mochaka\SerializationParser\Tests\Unit;

use Mochaka\SerializationParser\Data\EnumType;
use Mochaka\SerializationParser\Tests\TestCase;
use Mochaka\SerializationParser\Enums\VisibilityEnum;

class EnumTest extends TestCase
{
    public function testItParsesIntoBoolean(): void
    {
        $value = serialize(VisibilityEnum::PRIVATE);
        $this->assertSerializedReturnsType($value, EnumType::class);
    }

    public function testItHasCorrectValue(): void
    {
        $value = $this->parse(serialize(VisibilityEnum::PRIVATE));
        $this->assertSame($value->getEnumName(), VisibilityEnum::class);
        $this->assertSame($value->getValue(), 'PRIVATE');

        $value = $this->parse(serialize(VisibilityEnum::PUBLIC));
        $this->assertSame($value->getEnumName(), VisibilityEnum::class);
        $this->assertSame($value->getValue(), 'PUBLIC');
    }

    public function testItKnowsType(): void
    {
        $value = $this->parse(serialize(VisibilityEnum::PRIVATE));
        $this->assertType($value, 'enum');
    }

    public function testItReturnsArray(): void
    {
        $value = $this->parse(serialize(VisibilityEnum::PRIVATE));

        $this->assertSame([
            'enumName'   => VisibilityEnum::class,
            'name'       => null,
            'type'       => 'Enum',
            'value'      => 'PRIVATE',
            'visibility' => null,
        ], $value->toArray());
    }
}
