<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Exceptions;

use Shared\DomainError;

class InsufficientInventoryAvailable extends DomainError
{
    public function __construct(
        private string $name = ''
    ) {
        parent::__construct($this->errorMessage());
    }

    public function errorCode(): string
    {
        return 'insufficient_inventory_available';
    }

    protected function errorMessage(): string
    {
        return sprintf('The (%s) product is not available', $this->name);
    }
}
