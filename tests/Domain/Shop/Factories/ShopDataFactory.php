<?php

namespace Tests\Domain\Shop\Factories;

use Tests\Shared\GeneratorFactory;
use Domain\Shop\DataTransferObjects\ShopData;

class ShopDataFactory
{
    public static function make(
        ?string $id     = null,
        ?string $name   = null,
    ): ShopData
    {
        return new ShopData(
            $id     ?? GeneratorFactory::random()->uuid(),
            $name   ?? GeneratorFactory::random()->name(),
        );
    }
}
