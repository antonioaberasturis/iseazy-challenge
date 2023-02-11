<?php

declare(strict_types=1);

namespace Tests\Domain\ShopProduct\Factories;

use Domain\Product\DataTransferObjects\ProductsData;
use Tests\Shared\GeneratorFactory;
use Domain\ShopProduct\DataTransferObjects\ShopProductData;

class ShopProductDataFactory
{
    public static function make(
        ?string $shopId     = null,
        ?string $productId  = null,
        ?int $count         = null,
    ): ShopProductData
    {
        return new ShopProductData(
                $shopId     ??  GeneratorFactory::random()->uuid(),
                $productId  ??  GeneratorFactory::random()->uuid(),
                $count      ??  GeneratorFactory::random()->numberBetween(1),
        );
    }

    public static function makeCount(int $count): array
    {
        $shopProductsData = [];
        foreach(range(1, $count) as $item){
            $shopProductsData[] = static::make();
        }

        return $shopProductsData;
    }

    public static function makeFromProductsData(string $shopId, ProductsData $productsData): array
    {
        $shopProductsData = [];
        foreach($productsData->toArray() as $productData){
            $shopProductsData[] = new ShopProductData(
                shopId:     $shopId,
                productId:  $productData->id(),
                count:      $productData->count(),
            );
        }

        return $shopProductsData;
    }
}
