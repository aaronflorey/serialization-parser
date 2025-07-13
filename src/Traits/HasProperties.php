<?php

namespace Mochaka\SerializationParser\Traits;

use Mochaka\SerializationParser\Interfaces\TypeInterface;

trait HasProperties
{
    /** @var array<int, TypeInterface> */
    public array $properties = [];

    /**
     * @return array<int, TypeInterface>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function addProperty(TypeInterface $value): static
    {
        $this->properties[] = $value;

        return $this;
    }
}
