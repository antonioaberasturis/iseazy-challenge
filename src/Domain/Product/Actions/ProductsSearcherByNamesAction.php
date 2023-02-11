<?php

declare(strict_types=1);

namespace Domain\Product\Actions;

use Domain\Product\Product;
use Domain\Product\Collections\ProductCollection;

class ProductsSearcherByNamesAction
{
    public function __construct(
        private Product $productService,
    ) {
    }

    public function __invoke(array $productNames): ProductCollection
    {
        return $this->productService->query()->searchAllByNames($productNames);
    }
}
