<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Factories;

use Domain\Product\Product;
use Domain\Product\DataTransferObjects\ProductData;
use Domain\Product\DataTransferObjects\ProductsData;

class ProductFactory
{
    public static function makeFromProductsData(ProductsData $productsData): array
    {
        return array_map(fn(ProductData $productData) => 
                Product::factory()
                        ->id($productData->id())
                        ->name($productData->name())
                        ->make(), 
                $productsData->toArray()
        );
    }
}
