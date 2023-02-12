<?php

declare(strict_types=1);

namespace Shared;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApiExceptionsHttpStatusCodeMapping
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;
    private array $exceptions = [];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): int
    {
        $statusCode = isset($this->exceptions[$exceptionClass]) ? 
                        $this->exceptions[$exceptionClass] :
                        self::DEFAULT_STATUS_CODE;

        return $statusCode;
    }
}
