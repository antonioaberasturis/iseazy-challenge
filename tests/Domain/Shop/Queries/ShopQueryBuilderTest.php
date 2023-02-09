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
}
