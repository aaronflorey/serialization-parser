<?php

namespace Mochaka\SerializationParser\Interfaces;

interface ObjectTypeInterface extends TypeInterface
{
    /**
     * @return array<int, TypeInterface>
     */
    public function getProperties(): array;

    public function addProperty(TypeInterface $value): static;
}
