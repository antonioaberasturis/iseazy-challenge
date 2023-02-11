<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Queries;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Domain\Shop\Collections\ShopCollection;
use Domain\Product\Collections\ProductCollection;
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

    public function testShouldLoadProducts(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->create();
        /** @var ProductCollection $products */
        $products = Product::factory()->count(1)->create();
        /** @var ShopProduct $shopProducts */
        $shopProduct = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($products->first()->getId())
                                    ->productCount(1)
                                    ->create();
        /** @var Shop $response */
        $response = (new Shop)->query()->loadProducts($shop);

        $this->assertTrue($shop->is($response));
        $this->assertEquals($products->count(), $response->getProducts()->count());
        $this->assertTrue($products->first()->is($response->getProducts()->first()));
    }
}
