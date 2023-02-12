<?php

declare(strict_types=1);

namespace Application\Api\Product;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Shared\EloquentTransactionWrapper;
use Domain\Product\Requests\ProductsPostRequest;
use Domain\Product\Actions\ProductsCreatorAction;
use Domain\Product\DataTransferObjects\ProductsData;
use Illuminate\Http\Response;

class ProductsPostController extends ApiController
{
    public function __construct(
        private ProductsCreatorAction $creator,
        private EloquentTransactionWrapper $transactionWrapper
    ) {
        parent::__construct();
    }

    public function __invoke(ProductsPostRequest $request, string $shopId): JsonResponse
    {
        $productsData = new ProductsData($request->validated());
        
        $this->transactionWrapper->__invoke( fn() => $this->creator->__invoke($shopId, $productsData) );

        return response()->json([], 201);
    }

    protected function exceptions(): array
    {
        return [ProductSomeAlreadyExistsException::class => Response::HTTP_UNPROCESSABLE_ENTITY];
    }
}
