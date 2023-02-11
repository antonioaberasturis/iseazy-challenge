<?php

declare(strict_types=1);

namespace Tests\Domain\ShopProduct\Factories;

use Tests\Shared\GeneratorFactory;
use Domain\ShopProduct\ShopProduct;
use Domain\ShopProduct\DataTransferObjects\ShopProductData;
use Domain\ShopProduct\DataTransferObjects\ShopProductsData;

class ShopProductFactory
{
    public static function makeFromShopProductsData(ShopProductData ...$shopProductsData): array
    {
        return array_map(fn(ShopProductData $shopProductData) => 
                ShopProduct::factory()
                        ->shopId($shopProductData->shopId())
                        ->productId($shopProductData->productId())
                        ->productCount($shopProductData->count())
                        ->make(), 
                $shopProductsData
        );
    }
}
