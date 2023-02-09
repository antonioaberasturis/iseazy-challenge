<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Factories;

use Tests\Shared\GeneratorFactory;
use Domain\Shop\DataTransferObjects\ShopNameData;

class ShopNameDataFactory
{
    public static function make(
        ?string $name   = null,
    ): ShopNameData
    {
        return new ShopNameData(
            $name   ?? GeneratorFactory::random()->name(),
        );
    }
}
