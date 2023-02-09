<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Requests\ShopPostRequest;
use Domain\Shop\Actions\ShopCreatorAction;
use Domain\Shop\DataTransferObjects\ShopData;

class ShopPostController extends ApiController
{
    public function __construct(
        private ShopCreatorAction $creator,
    ) {
    }

    public function __invoke(ShopPostRequest $request): JsonResponse
    {
        $shopData = new ShopData(...$request->validated());
        
        $this->creator->__invoke($shopData);

        return response()->json([], 201);
    }
}
