<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Product\Actions\ProductRemoverByIdsAction;
use Domain\Shop\Shop;
use Domain\ShopProduct\Actions\ShopProductRemoverAction;
use Domain\ShopProduct\Actions\ShopProductSearcherAction;

class ShopRemoverAction
{
    public function __construct(
        private Shop $shopService,
        private ShopFinderAction $shopFinder,
        private ShopProductSearcherAction $shopProductSearcher,
        private ShopProductRemoverAction $shopProductRemover,
        private ProductRemoverByIdsAction $productRemover,
    ){   
    }

    public function __invoke(string $shopId): void
    {
        $shop = $this->shopFinder->__invoke($shopId);
        $shopProducts = $this->shopProductSearcher->__invoke($shopId);
        $this->shopProductRemover->__invoke($shopId);
        $productIds = $shopProducts->productIds();
        $this->productRemover->__invoke($productIds);
        $this->shopService->query()->deleteShop($shop);
    }
}
