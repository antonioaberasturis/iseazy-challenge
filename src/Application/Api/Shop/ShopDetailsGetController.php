<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Shared\ApiController;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Resources\ShopDetailsResource;
use Domain\Shop\Actions\ShopDetailsFinderAction;

class ShopDetailsGetController extends ApiController
{
    public function __construct(
        private readonly ShopDetailsFinderAction $detailsFinder
    ) {
        parent::__construct();
    }

    public function __invoke(string $id): JsonResponse
    {
        $shopDetail = $this->detailsFinder->__invoke($id);

        return response()->json(new ShopDetailsResource($shopDetail));
    }

    protected function exceptions(): array
    {
        return [];
    }
}
