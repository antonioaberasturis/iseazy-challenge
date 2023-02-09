<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\DataTransferObjects\ShopData;
use Domain\Shop\Exceptions\ShopAlreadyExistsException;

class ShopUpdaterAction
{
    public function __construct(
        private Shop $shop,
        private ShopFinderAction $finder,
        private ShopSearcherByNameAction $searcher,
    ){   
    }

    public function __invoke(string $id, ShopData $shopNameData): void
    {
        $shopWithNewName = $this->searcher->__invoke($shopNameData->name());

        if(null !== $shopWithNewName){
            throw new ShopAlreadyExistsException();
        }

        $shop = $this->finder->__invoke($id);
        
        $shop->setName($shopNameData->name());

        $this->shop->query()->updateShop($shop);
    }
}
