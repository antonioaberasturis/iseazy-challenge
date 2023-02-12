<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\DataTransferObjects\ProductCountData;
use Domain\Shop\Shop;
use Domain\ShopProduct\Actions\ShopProductUnitCounterAction;

class ProductCountUpdaterAction
{
    public function __construct(
        private Shop $shopService,
        private ShopFinderAction $finder,
    ) {
    }

    public function __invoke(ProductCountData $productCountData): void
    {
        $shop = $this->finder->__invoke($productCountData->shopId());
        $shop->incrementProductCount($productCountData->count());

        $this->shopService->query()->updateShop($shop);
    }
}
