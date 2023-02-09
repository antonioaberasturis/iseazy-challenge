<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\Actions\ShopCreatorAction;
use Domain\Shop\Actions\ShopSearcherByNameAction;
use Domain\Shop\Exceptions\ShopAlreadyExistsException;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Tests\Domain\Shop\Factories\ShopDataFactory;

class ShopCreatorActionTest extends ShopModuleUnitTestCase
{
    private readonly ShopCreatorAction $creator;
    private ShopSearcherByNameAction $searcher;

    public function setUp(): void
    {
        parent::setUp();
        $this->searcher = new ShopSearcherByNameAction($this->shopModel());
        $this->creator = new ShopCreatorAction(
            $this->shopModel(),
            $this->searcher
        );
    }

    public function testShouldCreateNewShop(): void
    {
        $shopData = ShopDataFactory::make();
        /** @var Shop $shop */
        $shop = Shop::factory()
                    ->id($shopData->id())
                    ->name($shopData->name())
                    ->make();

        $this->shouldNotSearchShopByName($shopData->name());
        $this->shouldCreateNewShop($shop);

        $this->creator->__invoke($shopData);
    }

    public function testShouldThrowShopAlreadyException(): void
    {
        $this->expectException(ShopAlreadyExistsException::class);
        
        $shopData = ShopDataFactory::make();
        /** @var Shop $shop */
        $shop = Shop::factory()
                    ->id($shopData->id())
                    ->name($shopData->name())
                    ->make();

        $this->shouldSearchShopByName($shopData->name(), $shop);

        $this->creator->__invoke($shopData);
    }
}
