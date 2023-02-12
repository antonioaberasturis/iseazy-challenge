<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Exceptions;

use Shared\DomainError;

class ShopProductNotExistsException extends DomainError
{
    public function errorCode(): string
    {
        return 'shop_product_not_exists';
    }

    protected function errorMessage(): string
    {
        return 'the resource not exists';
    }
}
