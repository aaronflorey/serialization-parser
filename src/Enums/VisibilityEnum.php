<?php

namespace Mochaka\SerializationParser\Enums;

enum VisibilityEnum
{
    case PUBLIC;
    case PROTECTED;
    case PRIVATE;

    public function toString(): string
    {
        return match ($this) {
            self::PUBLIC    => 'public',
            self::PROTECTED => 'protected',
            self::PRIVATE   => 'private',
        };
    }
}
