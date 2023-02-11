<?php

declare(strict_types=1);

namespace Tests\Domain\Product\Actions;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Illuminate\Support\Facades\Event;
use Domain\Product\Actions\ProductCreatorAction;
use Domain\Product\Actions\ProductsCreatorAction;
use Domain\Product\Collections\ProductCollection;
use Domain\Shop\Exceptions\ShopNotExistsException;
use Tests\Domain\Product\Factories\ProductFactory;
use Tests\Domain\Product\ProductModuleUnitTestCase;
use Tests\Domain\Product\Factories\ProductNamesFactory;
use Tests\Domain\Product\Factories\ProductsDataFactory;
use Domain\Product\Actions\ProductsSearcherByNamesAction;
use Tests\Domain\ShopProduct\Factories\ShopProductDataFactory;
use Domain\Product\Exceptions\ProductSomeAlreadyExistsException;

class ProductsCreatorActionTest extends ProductModuleUnitTestCase
{
    private readonly ProductsCreatorAction $creator;

    public function setUp(): void
    {
        parent::setUp();
        $this->creator = new ProductsCreatorAction(
                            new ProductCreatorAction(
                                $this->productModel()
                            ),
                            $this->shopProductCreator(),
                            new ProductsSearcherByNamesAction(
                                $this->productModel()
                            ),
                            $this->shopFinder()
        );
    }

    public function testShouldCreateNewProductsInExistingShop(): void
    {
        $productsData = ProductsDataFactory::makeCount(2);
        $productNames = ProductNamesFactory::makeFromProductsData($productsData);
        $products = ProductFactory::makeFromProductsData($productsData);
        /** @var Shop $shop */
        $shop = Shop::factory()->make();
        $shopProductData = ShopProductDataFactory::makeFromProductsData($shop->getId(), $productsData);


        $this->shouldFindShop($shop->getId(), $shop);
        $this->shouldNotFoundProductsByNames($productNames);
        $this->shouldCreateNewManyProduct($products);
        $this->shouldCreateNewManyShopProduct(...$shopProductData);
        Event::fake();

        $this->creator->__invoke($shop->getId(), $productsData);
    }

    public function testShouldThrowShopNotExistsExceptionWhenCreateNewProductWithNotExistingShop(): void
    {
        $this->expectException(ShopNotExistsException::class);

        $productsData = ProductsDataFactory::makeCount(2);
        /** @var Shop $shop */
        $shop = Shop::factory()->make();

        $this->shouldThrowShopNotExistsExceptionWhenFindShop($shop->getId());

        $this->creator->__invoke($shop->getId(), $productsData);
    }

    public function testShouldThrowProductSomeAlreadyExistsExceptionWhenCreateNewExistingProduct(): void
    {
        $this->expectException(ProductSomeAlreadyExistsException::class);

        $productsData = ProductsDataFactory::makeCount(2);
        $productNames = ProductNamesFactory::makeFromProductsData($productsData);
        /** @var Shop $shop */
        $shop = Shop::factory()->make();
        /** @var ProductCollection $products */
        $products = Product::factory()->count(1)->make();

        $this->shouldFindShop($shop->getId(), $shop);
        $this->shouldFoundProductsByNames($productNames, $products);

        $this->creator->__invoke($shop->getId(), $productsData);
    }
}
