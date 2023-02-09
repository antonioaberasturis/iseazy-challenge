<?php

namespace Tests\Shared;

use Faker\Generator;

class GeneratorFactory
{
    public static function random(): Generator
    {
        return app()->make(Generator::class);
    } 
}
