<?php

namespace Tests\Domain\Product\Actions;

use Domain\Product\Product;
use Tests\Domain\Product\ProductModuleUnitTestCase;
use Domain\Product\Actions\ProductsSearcherByNamesAction;

class ProductsSearcherByNamesActionTest extends ProductModuleUnitTestCase
{
    private readonly ProductsSearcherByNamesAction $searcher;

    public function setUp(): void
    {
        parent::setUp();
        $this->searcher = new ProductsSearcherByNamesAction($this->productModel());
    }

    public function testShouldSearchProductCollectionByName(): void
    {
        $products = Product::factory()->count(1)->make();
        /** @var array  $productNames */
        $productNames = $products->map(fn(Product $product) => $product->getName())->all();
        
        $this->shouldSearchAllByNames($productNames, $products);

        $response = $this->searcher->__invoke($productNames);

        $this->assertEquals($products, $response);
    }
}
