<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Actions;

use Domain\Product\Product;
use Illuminate\Support\Facades\Event;
use Domain\Product\Actions\ProductCreatorAction;
use Tests\Domain\Product\ProductModuleUnitTestCase;
use Tests\Domain\Product\Factories\ProductDataFactory;

class ProductCreatorActionTest extends ProductModuleUnitTestCase
{
    private readonly ProductCreatorAction $creator;

    public function setUp(): void
    {
        parent::setUp();
        $this->creator = new ProductCreatorAction($this->productModel());
    }

    public function testShouldCreateNewProduct(): void
    {
        $productData = ProductDataFactory::make();
        /** @var Product $product */
        $product = Product::factory()
                    ->id($productData->id())
                    ->name($productData->name())
                    ->make();
        $this->shouldCreateNewProduct($product);
        Event::fake();

        $this->creator->__invoke($productData);
    }
}
