<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Queries;

use Domain\Product\Product;
use Domain\Product\Collections\ProductCollection;
use Tests\Domain\Product\ProductModuleIntegrationTestCase;

class ProductQueryBuilderTest extends ProductModuleIntegrationTestCase
{
    public function testShouldCreateNewProduct(): void
    {
        /** @var Product $product */
        $product = Product::factory()->make();

        (new Product)->query()->createNew($product);

        $this->assertDatabaseHas((new Product)->getTable(), $product->toArray());
    }

    public function testShouldSearchProductCollectionByNames(): void
    {
        /** @var ProductCollection $products */
        $products = Product::factory()->count(1)->create();
        $names = $products->map(fn(Product $product) => $product->getName())->all();
        
        /** @var ProductCollection $response */
        $response = (new Product)->query()->searchAllByNames($names);

        $this->assertEquals($products->toArray(), $response->toArray());
    }

    public function testShouldSearchEmptyProductCollectionByNames(): void
    {
        /** @var Product $products */
        $products = Product::factory()->count(1)->make();
        $names = $products->map(fn(Product $product) => $product->getName())->all();
        
        $response = (new Product)->query()->searchAllByNames($names);

        $this->assertTrue($response->isEmpty());
    }

    public function testShouldSearchAtLeastOneProductByNames(): void
    {
        /** @var Product $products */
        $products = Product::factory()->count(2)->create();
        $productExisting = $products->first();
        $names = [$productExisting->getName(), 'nameProductNotExisting'];
        
        $response = (new Product)->query()->searchAllByNames($names);

        $this->assertCount(1, $response);
        $this->assertTrue($productExisting->is($response->first()));
    }
}
