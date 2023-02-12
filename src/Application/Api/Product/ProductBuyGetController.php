<?php

namespace Application\Api\Product;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Domain\ShopProduct\Actions\ExistsInventoryForAction;
use Domain\ShopProduct\Exceptions\InsufficientInventoryAvailable;
use Domain\ShopProduct\Exceptions\ShopProductNotExistsException;

class ProductBuyGetController extends ApiController
{
    public function __construct(
        private ExistsInventoryForAction $existsInventoryFor,
    ) {
        parent::__construct();
    }

    public function __invoke(string $shopId, string $productId): JsonResponse
    {
        $exists = $this->existsInventoryFor->__invoke($shopId, $productId);

        return response()->json(["message" => "The store is low in stock"]);
    }

    protected function exceptions(): array
    {
        return [
            ShopProductNotExistsException::class    => Response::HTTP_UNPROCESSABLE_ENTITY,
            InsufficientInventoryAvailable::class   => Response::HTTP_NOT_FOUND,
        ];
    }
}
