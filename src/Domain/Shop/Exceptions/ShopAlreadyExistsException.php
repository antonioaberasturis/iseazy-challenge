<?php

declare(strict_types=1);

namespace Domain\Shop\Exceptions;

use Shared\DomainError;

class ShopAlreadyExistsException extends DomainError
{
    public function errorCode(): string
    {
        return 'shop_already_exists';
    }

    protected function errorMessage(): string
    {
        return 'the resource already exists';
    }
}
