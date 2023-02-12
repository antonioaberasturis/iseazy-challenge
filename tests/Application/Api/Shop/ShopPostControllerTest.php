<?php

declare(strict_types=1);

namespace Tests\Application\Api\Shop;

use Domain\Shop\Shop;
use Tests\Domain\Shop\Factories\ShopDataFactory;
use Tests\Domain\Shop\ShopModuleIntegrationTestCase;

class ShopPostControllerTest extends ShopModuleIntegrationTestCase
{
    public function testShouldCreateShop(): void
    {
        $shopData = ShopDataFactory::make();

        $response = $this->post('api/shops', [
                        'id'    => $shopData->id(),
                        'name'  => $shopData->name(),
        ]);

        $response->assertStatus(201)->assertExactJson([]);
        $this->assertNotEmpty(Shop::find($shopData->id()));
    }

    public function testShouldResponseWithErrorMessageWhenCreateShopWithEqualsName(): void
    {
        $shopData = ShopDataFactory::make();
        /** @var Shop $shop */
        $shop = Shop::factory()->name($shopData->name())->create();
        
        $response = $this->post('api/shops', [
                        'id'    => $shopData->id(),
                        'name'  => $shopData->name(),
        ]);

        $response->assertStatus(422)->assertExactJson([
            "code" => "shop_already_exists",
            "message" => "the resource already exists",
        ]);
    }
}
