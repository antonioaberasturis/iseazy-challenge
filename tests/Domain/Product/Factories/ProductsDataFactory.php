<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Factories;

use Tests\Shared\GeneratorFactory;
use Domain\Product\DataTransferObjects\ProductsData;

class ProductsDataFactory
{
    public static function makeAsArray(): array
    {
        return [
                'id'    =>  GeneratorFactory::random()->uuid(),
                'name'  =>  GeneratorFactory::random()->name(),
                'count' =>  GeneratorFactory::random()->numberBetween(1),
            ];
    }

    public static function makeCount(int $count): ProductsData
    {
        return new ProductsData(static::makeAsArrayCount($count));
    }

    public static function makeAsArrayCount(int $count): array
    {
        $products = [];
        foreach(range(1, $count) as $item)
            $products[] = static::makeAsArray();

        return $products;
    }
}
