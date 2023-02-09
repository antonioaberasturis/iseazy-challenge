<?php

declare(strict_types=1);

namespace Tests\Application\Api\Shop;

use Domain\Shop\Shop;
use Tests\Domain\Shop\Factories\ShopDataFactory;
use Tests\Domain\Shop\ShopModuleIntegrationTestCase;

class ShopPutControllerTest extends ShopModuleIntegrationTestCase
{
    public function testShouldUpdateShop(): void
    {
        $shop = Shop::factory()->create();
        $shopData = ShopDataFactory::make($shop->getId());

        $response = $this->put('api/shops/'.$shop->getId(), [
                        'name'  => $shopData->name(),
        ]);

        $response->assertStatus(200)->assertExactJson([]);
        $this->assertDatabaseHas((new Shop)->getTable(), [
                'id'    => $shop->getId(),
                'name'  => $shopData->name(),
        ]);
    }
}
