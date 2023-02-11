<?php

declare(strict_types=1);

namespace Shared;

use Shared\DomainError;

class PersistenceTransactionException extends DomainError
{
    public function errorCode(): string
    {
        return 'persistence_transaction_exception';
    }

    protected function errorMessage(): string
    {
        return 'something went wrong internally';
    }
}
