<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Queries;

use Domain\ShopProduct\Collections\ShopProductCollection;
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

    public function searchAllByShopId(string $shopId): ShopProductCollection
    {
        return $this->where('shop_id', $shopId)->get();
    }

    public function deleteAllByShopId(string $shopId): void
    {
        $this->where('shop_id', $shopId)->delete();
    }

    public function findByShopIdAndProductId(string $shopId, string $productId): ?ShopProduct
    {
        return $this->where('shop_id', $shopId)
                    ->where('product_id', $productId)
                    ->limit(1)
                    ->first();
    }
}
