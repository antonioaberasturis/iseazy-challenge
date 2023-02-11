<?php

declare(strict_types=1);

namespace Domain\ShopProduct\DataTransferObjects;

class ShopProductData
{
    public function __construct(
        private readonly string $shopId,
        private readonly string $productId,
        private readonly int    $count,
    ) {
    }

    public function shopId(): string
    {
        return $this->shopId;
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function count(): int
    {
        return $this->count;
    }
}
