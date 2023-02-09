<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\Shop;

class ShopSearcherByNameAction
{
    public function __construct(
        private Shop $shop,
    ){   
    }

    public function __invoke(string $shopName): ?Shop
    {
        return $this->shop->query()->searchByName($shopName);
    }
}
