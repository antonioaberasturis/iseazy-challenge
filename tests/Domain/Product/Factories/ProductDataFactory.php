<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Factories;

use Tests\Shared\GeneratorFactory;
use Domain\Product\DataTransferObjects\ProductData;

class ProductDataFactory
{
    public static function make(
        ?string $id      = null,
        ?string $name    = null,
        ?int $count      = null,
    ): ProductData
    {
        return new ProductData(
                $id    ??  GeneratorFactory::random()->uuid(),
                $name  ??  GeneratorFactory::random()->name(),
                $count ??  GeneratorFactory::random()->numberBetween(1),
        );
    }
}
