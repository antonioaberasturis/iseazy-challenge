<?php

declare(strict_types=1);

namespace Tests\Application\Api\Shop;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Illuminate\Support\Facades\Event;
use Domain\ShopProduct\Events\ShopProductAdded;
use Tests\Domain\Shop\ShopModuleIntegrationTestCase;

class ShopDetailsGetControllerTest extends ShopModuleIntegrationTestCase
{
    public function testShouldGetShopDetailsWithProducts(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->productCount(1)->create();
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var ShopProduct $shopProduct */
        $shopProduct = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($product->getId())
                                    ->productCount(1)
                                    ->create();

        $response = $this->get("api/shops/{$shop->getId()}/details");

        $response->assertStatus(200)->assertExactJson([
            'id' => $shop->getId(),
            'name' => $shop->getName(),
            'product_count' => $shop->getProductCount(),
            'products' => [
                [
                    'id'    => $product->getId(),
                    'name'  => $product->getName(),
                ]
            ]
        ]);
    }

    public function testShouldUpdateProductCounterOnProductCreated(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->productCount(0)->create();
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var ShopProduct $shopProduct */
        $shopProduct = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($product->getId())
                                    ->create();
        $shopProductAdded = new ShopProductAdded($shop->getId(), $shopProduct->getCount());
        Event::dispatch($shopProductAdded);

        $response = $this->get("api/shops/{$shop->getId()}/details");

        $response->assertStatus(200)->assertJson([
            'id' => $shop->getId(),
            'product_count' => $shopProduct->getCount(),
        ]);
    }

}
