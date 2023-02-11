<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Events;

class ShopProductAdded
{
    public function __construct(
        public readonly string $shopId,
        public readonly int    $count,
    ) {
    }
}
