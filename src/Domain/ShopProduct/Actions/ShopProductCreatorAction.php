<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Actions;

use Domain\ShopProduct\ShopProduct;
use Domain\ShopProduct\Events\ShopProductAdded;
use Domain\ShopProduct\DataTransferObjects\ShopProductData;

class ShopProductCreatorAction
{
    public function __construct(
        private ShopProduct $shopProductService,
    ) {
    }

    public function __invoke(ShopProductData ...$shopProductData): void
    {
        $shopProducts = [];
        $shopId = null;
        $productTotalCount = 0;

        /** @var ShopProductData  $shopProductData */
        foreach($shopProductData as $shopProductData){
            $shopProducts[] = (new ShopProduct)->fill([
                                    'shop_id'       => $shopProductData->shopId(),
                                    'product_id'    => $shopProductData->productId(),
                                    'count'         => $shopProductData->count(),
                                ]);
            $productTotalCount += $shopProductData->count();
            $shopId = $shopProductData->shopId();
        }

        $this->shopProductService->query()->createNewMany(...$shopProducts);

        event(new ShopProductAdded(
            shopId: $shopId,
            count:  $productTotalCount,
        ));
    }
}
