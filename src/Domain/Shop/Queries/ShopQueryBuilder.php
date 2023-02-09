<?php

declare(strict_types=1);

namespace Domain\Shop\Queries;

use Domain\Shop\Collections\ShopCollection;
use Illuminate\Database\Eloquent\Builder;

class ShopQueryBuilder extends Builder
{
    public function searchAllShop(): ShopCollection
    {
        return $this->get();
    }
}
