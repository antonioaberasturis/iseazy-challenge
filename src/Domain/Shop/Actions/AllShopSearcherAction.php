<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\Collections\ShopCollection;
use Domain\Shop\Shop;

class AllShopSearcherAction
{
    public function __construct(
        private readonly Shop $shop
    ) {  
    }
    public function __invoke(): ShopCollection
    {
        return $this->shop->query()->searchAllShop();
    }
}
