<?php

namespace Shared;

use Throwable;
use Shared\DomainError;
use Illuminate\Http\JsonResponse;

class ApiExceptionListener
{
    public function __construct(
        private ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    ) {
    }

    public function handle(Throwable $exception): JsonResponse
    {
        return response()->json(
            [
                'code'    => $this->exceptionCodeFor($exception),
                'message' => $exception->getMessage(),
            ],
            $this->exceptionHandler->statusCodeFor($exception::class)
        );
    }

    private function exceptionCodeFor(Throwable $error): string
    {
        $domainErrorClass = DomainError::class;

        return $error instanceof $domainErrorClass ? 
                    $error->errorCode() : 
                    Utils::toSnakeCase(Utils::extractClassName($error));
    }
}
