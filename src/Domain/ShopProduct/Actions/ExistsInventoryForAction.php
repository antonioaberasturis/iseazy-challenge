<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Actions;

use Domain\ShopProduct\Exceptions\InsufficientInventoryAvailable;

class ExistsInventoryForAction
{
    public function __construct(
        private ShopProductFinderAction $shopProductFinder,
    ) {
    }

    public function __invoke(string $shopId, string $productId): bool
    {
        $shopProduct = $this->shopProductFinder->__invoke($shopId, $productId);

        if(!$shopProduct->existsInventory()){
            throw new InsufficientInventoryAvailable($shopProduct->getProductId());
        }

        return true;
    }
}
