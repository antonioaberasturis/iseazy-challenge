<?php

namespace Domain\ShopProduct\Actions;

use Domain\ShopProduct\ShopProduct;

class ShopProductRemoverAction
{
    public function __construct(
        private ShopProduct $shopProductService,
    ) {
    }
    
    public function __invoke(string $shopId): void
    {
        $this->shopProductService->query()->deleteAllByShopId($shopId);
    }
}
