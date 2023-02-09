<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\Actions\ShopFinderAction;
use Domain\Shop\Actions\ShopUpdaterAction;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Tests\Domain\Shop\Factories\ShopDataFactory;
use Domain\Shop\Actions\ShopSearcherByNameAction;
use Domain\Shop\Exceptions\ShopNotExistsException;
use Domain\Shop\Exceptions\ShopAlreadyExistsException;

class ShopUpdaterActionTest extends ShopModuleUnitTestCase
{
    private readonly ShopUpdaterAction $updater;
    private readonly ShopFinderAction $finder;
    private readonly ShopSearcherByNameAction $searcher;

    public function setUp(): void
    {
        parent::setUp();
        $this->searcher = new ShopSearcherByNameAction($this->shopModel());
        $this->finder = new ShopFinderAction($this->shopModel());
        $this->updater = new ShopUpdaterAction(
            $this->shopModel(),
            $this->finder,
            $this->searcher,
        );
    }

    public function testShouldUpdateShop(): void
    {
        $shopData = ShopDataFactory::make();
        /** @var Shop $shop */
        $shop = Shop::factory()->make();

        $this->shouldNotSearchShopByName($shopData->name());
        $this->shouldFindShop($shop->getId(), $shop);
        $this->shouldUpdateShop($shop);

        $this->updater->__invoke($shop->getId(), $shopData);
    }

    public function testShouldThrowShopAlreadyException(): void
    {
        $this->expectException(ShopAlreadyExistsException::class);
        
        $shopData = ShopDataFactory::make();
        /** @var Shop $shop */
        $shop = Shop::factory()->name($shopData->name())->make();

        $this->shouldSearchShopByName($shopData->name(), $shop);

        $this->updater->__invoke($shop->getId(), $shopData);
    }

    public function testShouldThrowShopNotExistsException(): void
    {
        $this->expectException(ShopNotExistsException::class);
        
        $shopData = ShopDataFactory::make();
        /** @var Shop $shop */
        $shop = Shop::factory()->make();

        $this->shouldNotSearchShopByName($shopData->name());
        $this->shouldNotFindShop($shop->getId());

        $this->updater->__invoke($shop->getId(), $shopData);
    }
}
