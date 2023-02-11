<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\Actions\ShopFinderAction;

class ShopDetailsFinderAction
{
    public function __construct(
        private Shop $shopService,
        private ShopFinderAction $finder
    ){   
    }

    public function __invoke(string $id): Shop
    {
        $shop = $this->finder->__invoke($id);

        return $this->shopService->query()->loadProducts($shop);
    }
}
