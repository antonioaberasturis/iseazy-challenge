<?php

declare(strict_types=1);

namespace Application\Api\Shop;

use Shared\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Domain\Shop\Requests\ShopPutRequest;
use Domain\Shop\Actions\ShopUpdaterAction;
use Domain\Shop\DataTransferObjects\ShopData;
use Domain\Shop\DataTransferObjects\ShopNameData;
use Domain\Shop\Exceptions\ShopNotExistsException;
use Domain\Shop\Exceptions\ShopAlreadyExistsException;

class ShopPutController extends ApiController
{
    public function __construct(
        private ShopUpdaterAction $updater,
    ) {
        parent::__construct();
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

    protected function exceptions(): array
    {
        return [
                ShopAlreadyExistsException::class   => Response::HTTP_UNPROCESSABLE_ENTITY,
                ShopNotExistsException::class       => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];
    }
}
