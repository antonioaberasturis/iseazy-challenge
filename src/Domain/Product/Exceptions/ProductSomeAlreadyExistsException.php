<?php

declare(strict_types=1);

namespace Domain\Product\Exceptions;

use Shared\DomainError;

class ProductSomeAlreadyExistsException extends DomainError
{
    public function errorCode(): string
    {
        return 'product_some_already_exists';
    }

    protected function errorMessage(): string
    {
        return 'Some resource already exists';
    }
}
