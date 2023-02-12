<?php

declare(strict_types=1);

namespace Domain\Product\Actions;

use Domain\Product\Product;

class ProductRemoverByIdsAction
{
    public function __construct(
        private Product $productService,
    ) {
    }

    public function __invoke(array $productIds): void
    {
        $this->productService->query()->deleteAllByIds($productIds);
    }
}
