<?php

declare(strict_types=1);

namespace Domain\Shop\Queries;

use Domain\Shop\Shop;
use Illuminate\Database\Eloquent\Builder;
use Domain\Shop\Collections\ShopCollection;

class ShopQueryBuilder extends Builder
{
    public function searchAllShop(): ShopCollection
    {
        return $this->get();
    }

    public function createNew(Shop $shop): void
    {
        $shop->save();
    }

    public function searchByName(string $name): ?Shop
    {
        return $this->where('name', $name)->limit(1)->first();
    }
}
