<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Actions\ShopRemoverAction;
use Domain\Shop\Exceptions\ShopNotExistsException;

class ShopDeleteController extends ApiController
{
    public function __construct(
        private ShopRemoverAction $remover,
    ) {
        parent::__construct();
    }

    public function __invoke(string $id): JsonResponse
    {
        $this->remover->__invoke($id);

        return response()->json([], 204);
    }

    protected function exceptions(): array
    {
        return [ShopNotExistsException::class => Response::HTTP_UNPROCESSABLE_ENTITY];
    }
}
