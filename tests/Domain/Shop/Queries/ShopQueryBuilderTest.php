<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Queries;

use Domain\Shop\Shop;
use Domain\Shop\Collections\ShopCollection;
use Tests\Domain\Shop\ShopModuleIntegrationTestCase;

class ShopQueryBuilderTest extends ShopModuleIntegrationTestCase
{
    public function testShouldGetAllShops(): void
    {
        /** @var ShopCollection $shops */
        $shops = Shop::factory()->count(1)->create();

        /** @var ShopCollection $response */
        $response = (new Shop)->query()->searchAllShop();

        $this->assertEquals($shops->toArray(), $response->toArray());
    }

    public function testShouldGetEmptyShopCollection(): void
    {
        /** @var ShopCollection $response */
        $response = (new Shop)->query()->searchAllShop();

        $this->assertTrue($response->isEmpty());
    }

    public function testShouldCreateNewShop(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->make();

        (new Shop)->query()->createNew($shop);

        $this->assertDatabaseHas((new Shop)->getTable(), $shop->toArray());
    }

    public function testShouldSearchShopByName(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->create();

        $response = (new Shop)->query()->searchByName($shop->getName());

        $this->assertTrue($shop->is($response) && ($shop->getName() === $response->getName()));
    }

    public function testShouldNotSearchShopByName(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->make();

        $response = (new Shop)->query()->searchByName($shop->getName());

        $this->assertEmpty($response);
    }

    public function testShouldUpdateShop(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->create();
        /** @var Shop $newShop */
        $newShop = Shop::factory()->id($shop->getId())->make();
        $shop->setName($newShop->getName());

        (new Shop)->query()->updateShop($shop);

        $this->assertDatabaseHas($shop->getTable(), $shop->toArray());
    }
}
