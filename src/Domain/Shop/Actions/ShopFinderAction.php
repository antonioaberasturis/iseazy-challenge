<?php

declare(strict_types=1);

namespace Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\Exceptions\ShopNotExistsException;

class ShopFinderAction
{
    public function __construct(
        private Shop $shop,
    ){   
    }

    public function __invoke(string $id): Shop
    {
        $shop = $this->shop->query()->find($id);

        if(null === $shop){
            throw new ShopNotExistsException();
        }

        return $shop;
    }
}
