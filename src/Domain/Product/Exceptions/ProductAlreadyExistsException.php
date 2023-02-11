<?php

declare(strict_types=1);

namespace Domain\Product\Exceptions;

use Shared\DomainError;

class ProductAlreadyExistsException extends DomainError
{
    public function errorCode(): string
    {
        return 'product_already_exists';
    }

    protected function errorMessage(): string
    {
        return 'the resource already exists';
    }
}
