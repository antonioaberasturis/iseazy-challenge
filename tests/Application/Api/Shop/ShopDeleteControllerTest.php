<?php

declare(strict_types=1);

namespace Tests\Application\Api\Shop;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Tests\Domain\Shop\ShopModuleIntegrationTestCase;

class ShopDeleteControllerTest extends ShopModuleIntegrationTestCase
{
    public function testShouldRemoveShopWithProducts(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->create();
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var ShopProduct $shopProduct */
        $shopProduct = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($product->getId())
                                    ->create();

        $response = $this->delete("api/shops/{$shop->getId()}");

        $response->assertNoContent();
        $this->assertDatabaseEmpty(Shop::class);
        $this->assertDatabaseEmpty(ShopProduct::class);
        $this->assertDatabaseEmpty(Product::class);
    }
}
