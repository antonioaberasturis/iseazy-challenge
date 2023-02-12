<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Collections;

use Domain\ShopProduct\ShopProduct;
use Illuminate\Database\Eloquent\Collection;

class ShopProductCollection extends Collection
{
    public function productIds(): array
    {
        return $this->map(fn(ShopProduct $item) => $item->getProductId())->all();
    }
}
