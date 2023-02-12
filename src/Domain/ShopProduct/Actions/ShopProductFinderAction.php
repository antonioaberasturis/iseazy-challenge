<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Actions;

use Domain\ShopProduct\ShopProduct;
use Domain\ShopProduct\Exceptions\ShopProductNotExistsException;

class ShopProductFinderAction
{
    public function __construct(
        private ShopProduct $shopProductService,
    ) {
    }

    public function __invoke(string $shopId, string $productId): ShopProduct
    {
        $shopProduct = $this->shopProductService->query()->findByShopIdAndProductId($shopId, $productId);

        if(null === $shopProduct){
            throw new ShopProductNotExistsException();
        }

        return $shopProduct;
    }
}
