<?php

declare(strict_types=1);

namespace Domain\Shop\DataTransferObjects;

class ShopNameData
{
    public function __construct(
        private readonly string $name,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }
}
