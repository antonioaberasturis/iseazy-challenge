<?php

declare(strict_types=1);

namespace Domain\Shop\Listeners;

use Domain\ShopProduct\Events\ShopProductAdded;
use Domain\Shop\Actions\ProductCountUpdaterAction;
use Domain\Shop\DataTransferObjects\ProductCountData;

class UpdateProductCountOnShopProductAdded
{
    public function __construct(
        private ProductCountUpdaterAction $productCountUpdater
    ) {  
    }

    public function handle(ShopProductAdded $event): void
    {
        $productCount = new ProductCountData($event->shopId, $event->count);
        $this->productCountUpdater->__invoke($productCount);
    }
}
