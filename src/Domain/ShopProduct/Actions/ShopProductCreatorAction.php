<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Actions;

use Domain\ShopProduct\ShopProduct;
use Domain\Product\DataTransferObjects\ProductsData;
use Domain\ShopProduct\DataTransferObjects\ShopProductData;
use Domain\ShopProduct\DataTransferObjects\ShopProductsData;

class ShopProductCreatorAction
{
    public function __construct(
        private ShopProduct $shopProductService,
    ) {
    }

    public function __invoke(ShopProductData ...$shopProductData): void
    {
        $shopProducts = array_map(fn(ShopProductData $shopProductData) => 
                                    (new ShopProduct)->fill([
                                        'shop_id'       => $shopProductData->shopId(),
                                        'product_id'    => $shopProductData->productId(),
                                        'count'         => $shopProductData->count(),
                                    ]), 
                                    $shopProductData
        );

        $this->shopProductService->query()->createNewMany(...$shopProducts);
    }
}
