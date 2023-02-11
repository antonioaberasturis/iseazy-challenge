<?php

declare(strict_types=1);

namespace Tests\Application\Api\Product;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Tests\Domain\Product\Factories\ProductsDataFactory;
use Tests\Domain\Product\ProductModuleIntegrationTestCase;

class ProductsPostControllerTest extends ProductModuleIntegrationTestCase
{
    public function testShouldCreateProductsToShop(): void
    {
        /** @var ProductsData[] $productsData */
        $productsData = ProductsDataFactory::makeAsArrayCount(2);
        $shop = Shop::factory()->create();

        $response = $this->post("api/shops/{$shop->getId()}/products", $productsData);

        $response->assertStatus(201)->assertExactJson([]);
        
        foreach($productsData as $productData){
            $this->assertDatabaseHas((new ShopProduct)->getTable(), [
                'shop_id'       => $shop->getId(),
                'product_id'    => $productData['id'],
                'count'         => $productData['count'],
            ]);

            unset($productData['count']);
            
            /** @var array $productData */
            $this->assertDatabaseHas((new Product)->getTable(), $productData);
        }
    }
}
