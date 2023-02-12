<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Listeners;

use Domain\Shop\Shop;
use Illuminate\Support\Facades\Event;
use Domain\Shop\Actions\ShopFinderAction;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Domain\ShopProduct\Events\ShopProductAdded;
use Domain\Shop\Actions\ProductCountUpdaterAction;
use Domain\Shop\Listeners\UpdateProductCountOnShopProductAdded;

class UpdateProductCountOnShopProductAddedTest extends ShopModuleUnitTestCase
{
    private readonly UpdateProductCountOnShopProductAdded $updater;

    public function setUp(): void
    {
        parent::setUp();
        $this->updater = new UpdateProductCountOnShopProductAdded(
                                new ProductCountUpdaterAction(
                                    $this->shopModel(),
                                    new ShopFinderAction(
                                        $this->shopModel()
                                    )
                                )
            );
    }

    public function testShouldUpdateProductCount(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->make();
        $shopProductAdded = new ShopProductAdded($shop->getId(), 10);

        $this->shouldFindShop($shop->getId(), $shop);
        $this->shouldUpdateShop($shop);

        $this->updater->handle($shopProductAdded);
    }

    public function testShouldSubscribeToProductCreated(): void
    {
        Event::fake();

        Event::assertListening(ShopProductAdded::class, UpdateProductCountOnShopProductAdded::class);
    }
}
