<?php

declare(strict_types=1);

namespace Domain\Shop\DataTransferObjects;

class ProductCountData
{
    public function __construct(
        private readonly string $shopId,
        private readonly int    $count,
    ) {
    }

    public function shopId(): string
    {
        return $this->shopId;
    }

    public function count(): int
    {
        return $this->count;
    }
}
