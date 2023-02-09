<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\DataTransferObjects\ShopData;
use Domain\Shop\Actions\ShopSearcherByNameAction;
use Domain\Shop\Exceptions\ShopNotExistsException;
use Domain\Shop\Exceptions\ShopAlreadyExistsException;

class ShopCreatorAction
{
    public function __construct(
        private Shop $shop,
        private ShopSearcherByNameAction $searcherByName
    ) {
    }

    public function __invoke(ShopData $shopData): void
    {
        $this->ensureShopNotExists($shopData->name());

        $shop = (new Shop)->fill([
            'id'    => $shopData->id(),
            'name'  => $shopData->name(),
        ]);

        $this->shop->query()->createNew($shop);
    }

    private function ensureShopNotExists(string $shopName): void
    {
        if($this->searcherByName->__invoke($shopName)){
            throw new ShopAlreadyExistsException();
        }
    }
}
