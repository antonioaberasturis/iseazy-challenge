<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Actions;

use Domain\ShopProduct\Collections\ShopProductCollection;
use Domain\ShopProduct\ShopProduct;

class ShopProductSearcherAction
{
    public function __construct(
        private ShopProduct $shopProductService,
    ) {
    }
    
    public function __invoke(string $shopId): ShopProductCollection
    {
        return $this->shopProductService->query()->searchAllByShopId($shopId);
    }
}
