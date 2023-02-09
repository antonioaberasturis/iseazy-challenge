<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Requests\ShopPutRequest;
use Domain\Shop\Actions\ShopUpdaterAction;
use Domain\Shop\DataTransferObjects\ShopData;
use Domain\Shop\DataTransferObjects\ShopNameData;

class ShopPutController extends ApiController
{
    public function __construct(
        private ShopUpdaterAction $updater,
    ) {
    }

    public function __invoke(ShopPutRequest $request, string $id): JsonResponse
    {
        $shopData = new ShopData(...[
            'id' => $id, 
            ...$request->validated()
        ]);
        
        $this->updater->__invoke($id, $shopData);

        return response()->json([], 200);
    }


}
