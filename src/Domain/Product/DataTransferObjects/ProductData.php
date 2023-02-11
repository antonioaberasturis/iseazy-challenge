<?php

declare(strict_types=1);

namespace Domain\Product\DataTransferObjects;

class ProductData
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly int    $count,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function count(): int
    {
        return $this->count;
    }
}
