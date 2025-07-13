<?php

namespace Mochaka\SerializationParser\Tests\Fixtures;

use Mochaka\SerializationParser\Enums\VisibilityEnum;

class TestClass
{
    public int $int = 1;
    public string $string = 'string';
    public VisibilityEnum $enum = VisibilityEnum::PUBLIC;
    private bool $bool = true;
    private float $float = 1.1;
    protected array $array = [1, 2, 3];
    protected object $object;
    protected null $null = null;

    public function __construct()
    {
        $this->object = (object) ['int' => 1, 'array' => [1, 2, 3]];
    }
}
