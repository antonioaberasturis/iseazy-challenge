<?php

declare(strict_types=1);

namespace Tests\Application\Api\Shop;

use Domain\Shop\Shop;
use Domain\Shop\Collections\ShopCollection;
use Tests\Domain\Shop\ShopModuleIntegrationTestCase;

class ShopsGetControllerTest extends ShopModuleIntegrationTestCase
{
    public function testShouldGetShopsWithProductCount(): void
    {
        /** @var ShopCollection $shops */
        $shops = Shop::factory()->count(1)->create();

        $response = $this->get('api/shops');

        $response->assertStatus(200)->assertExactJson($shops->toArray());
    }
}
