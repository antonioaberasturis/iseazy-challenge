<?php

declare(strict_types=1);

namespace Tests\Application\Api\Product;

use Domain\Product\Events\ProductCreated;
use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\Events\ShopProductAdded;
use Domain\ShopProduct\ShopProduct;
use Illuminate\Support\Facades\Event;
use Tests\Domain\Product\Factories\ProductsDataFactory;
use Tests\Domain\Product\ProductModuleIntegrationTestCase;

class ProductsPostControllerTest extends ProductModuleIntegrationTestCase
{
    public function testShouldCreateProductsToShop(): void
    {
        /** @var ProductsData[] $productsData */
        $productsData = ProductsDataFactory::makeAsArrayCount(2);
        $shop = Shop::factory()->create();
        $productTotalCount = 0;
        Event::fake();

        $response = $this->post("api/shops/{$shop->getId()}/products", $productsData);

        $response->assertStatus(201)->assertExactJson([]);
        
        foreach($productsData as $productData){
            $productTotalCount += $productData['count'];

            Event::assertDispatched(fn(ProductCreated $event) => (array) $event === $productData);
            $this->assertDatabaseHas((new ShopProduct)->getTable(), [
                'shop_id'       => $shop->getId(),
                'product_id'    => $productData['id'],
                'count'         => $productData['count'],
            ]);

            unset($productData['count']);
            
            /** @var array $productData */
            $this->assertDatabaseHas((new Product)->getTable(), $productData);
        }
        Event::assertDispatched(function(ShopProductAdded $event)use($productTotalCount, $shop){
            return ($event->shopId === $shop->getId()) && ($event->count === $productTotalCount);
        });
    }
}
