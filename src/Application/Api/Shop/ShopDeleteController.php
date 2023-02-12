<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Actions\ShopRemoverAction;

class ShopDeleteController extends ApiController
{
    public function __construct(
        private ShopRemoverAction $remover,
    ) {
    }

    public function __invoke(string $id): JsonResponse
    {
        $this->remover->__invoke($id);

        return response()->json([], 204);
    }
}
