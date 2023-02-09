<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Domain\Shop\Actions\AllShopSearcherAction;
use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Resources\ShopResource;

class ShopsGetController extends ApiController
{
    public function __construct(
        private readonly AllShopSearcherAction $searcher
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $shops = $this->searcher->__invoke();

        return response()->json(ShopResource::collection($shops));
    }
}
