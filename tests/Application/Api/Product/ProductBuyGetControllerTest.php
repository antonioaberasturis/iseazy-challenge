<?php

declare(strict_types=1);

namespace Tests\Application\Api\Product;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Tests\Domain\Product\ProductModuleIntegrationTestCase;

class ProductBuyGetControllerTest extends ProductModuleIntegrationTestCase
{
    public function testShouldGetInsufficentInventaryResponse(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->create();
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var ShopProduct $shopProduct */
        $shopProduct = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($product->getId())
                                    ->productCount(0)
                                    ->create();

        $response = $this->get("api/shops/{$shop->getId()}/products/{$product->getId()}/buy");

        $response->assertNotFound()->assertExactJson([
            "code"      => 'insufficient_inventory_available',
            "message"   => sprintf('The (%s) product is not available', $product->getId()),
        ]);
    }

    public function testShouldGetShopLowStockResponse(): void
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

        $response = $this->get("api/shops/{$shop->getId()}/products/{$product->getId()}/buy");

        $response->assertOk()->assertExactJson([
            "message"   => "The store is low in stock",
        ]);
    }

    public function testShouldGetErrorResponseWhenBuyNotExistingProductInShop(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->create();
        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->get("api/shops/{$shop->getId()}/products/{$product->getId()}/buy");

        $response->assertUnprocessable()->assertExactJson([
            "code"      => 'shop_product_not_exists',
            "message"   => 'the resource not exists',
        ]);
    }
}
