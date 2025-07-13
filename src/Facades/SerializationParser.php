<?php

namespace Mochaka\SerializationParser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mochaka\SerializationParser\SerializationParser
 */
class SerializationParser extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mochaka\SerializationParser\SerializationParser::class;
    }
}
