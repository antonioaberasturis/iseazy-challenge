<?php

declare(strict_types=1);

namespace Domain\Shop\Exceptions;

use Shared\DomainError;

class ShopNotExistsException extends DomainError
{
    public function errorCode(): string
    {
        return 'shop_not_exists';
    }

    protected function errorMessage(): string
    {
        return 'the resource not exists';
    }
}
