<?php

declare(strict_types=1);

namespace Domain\Product\Queries;

use Domain\Product\Collections\ProductCollection;
use Domain\Product\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function createNew(Product $product): void
    {
        $product->save();
    }

    public function searchAllByNames(array $names): ?ProductCollection
    {
        return $this->whereIn('name', $names)->get();
    }
}
