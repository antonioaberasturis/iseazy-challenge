<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Queries;

use Domain\ShopProduct\ShopProduct;
use Illuminate\Database\Eloquent\Builder;

class ShopProductQueryBuilder extends Builder
{
    public function createNewMany(ShopProduct ...$shopProducts): void
    {
        $many = [];
        foreach($shopProducts as $item){
            $many[] = $item->toArray();
        }
        $this->insert($many);
    }
}
