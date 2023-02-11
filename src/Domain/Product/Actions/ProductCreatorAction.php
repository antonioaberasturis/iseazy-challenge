<?php

declare(strict_types=1);

namespace Domain\Product\Actions;

use Domain\Product\Product;
use Domain\Product\DataTransferObjects\ProductData;
use Domain\Product\Events\ProductCreated;

class ProductCreatorAction
{
    public function __construct(
        private Product $productService,
    ) {
    }

    public function __invoke(ProductData $productData): void
    {
        $product = (new Product)->fill([
            'id'    => $productData->id(),
            'name'  => $productData->name(),
        ]);

        $this->productService->query()->createNew($product);
        
        event(new ProductCreated(
            id:     $productData->id(),
            name:   $productData->name(),
            count:  $productData->count(),
        ));
    }
}
