<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Factories;

use Domain\Product\DataTransferObjects\ProductData;
use Domain\Product\DataTransferObjects\ProductsData;

class ProductNamesFactory
{
    public static function makeFromProductsData(ProductsData $productsData): array
    {
        return array_map(fn(ProductData $productData) => 
                            $productData->name(), 
                            $productsData->toArray()
        );
    }
}
