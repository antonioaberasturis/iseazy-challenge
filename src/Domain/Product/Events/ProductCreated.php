<?php

declare(strict_types=1);

namespace Domain\Product\Events;

class ProductCreated
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int    $count,
    ) {
    }
}
