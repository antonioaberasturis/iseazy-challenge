<?php

declare(strict_types=1);

namespace Tests\Domain\Product;

use Mockery;
use Tests\TestCase;
use Domain\Shop\Shop;
use Mockery\MockInterface;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Domain\Shop\Actions\ShopFinderAction;
use Domain\Product\Queries\ProductQueryBuilder;
use Domain\Product\Collections\ProductCollection;
use Domain\Shop\Exceptions\ShopNotExistsException;
use Domain\ShopProduct\Actions\ShopProductCreatorAction;
use Domain\ShopProduct\DataTransferObjects\ShopProductData;

abstract class ProductModuleUnitTestCase extends TestCase
{
    protected Product $product;
    protected ProductQueryBuilder $queryBuilder;
    protected ShopFinderAction $shopFinder;
    protected ShopProductCreatorAction $shopProductCreator;

    protected function productModel(): MockInterface|Product
    {
        return $this->product = $this->product ?? $this->partialMock(Product::class);
    }

    protected function productQueryBuilder(): MockInterface|ProductQueryBuilder
    {
        return $this->queryBuilder = $this->queryBuilder ?? $this->mock(ProductQueryBuilder::class);
    }

    protected function shopFinder(): MockInterface|ShopFinderAction
    {
        return $this->shopFinder = $this->shopFinder ?? $this->mock(ShopFinderAction::class);
    }

    protected function shopProductCreator(): MockInterface|ShopProductCreatorAction
    {
        return $this->shopProductCreator = $this->shopProductCreator ?? $this->mock(ShopProductCreatorAction::class);
    }

    public function shouldMakeProductQueryBuilder(): void
    {
        $this->productModel()
            ->shouldReceive('query')
            ->withNoArgs()
            ->andReturn($this->productQueryBuilder());
    }

    protected function shouldCreateNewProduct(Product $newProduct): void
    {
        $this->shouldMakeProductQueryBuilder();
        $this->productQueryBuilder()
            ->shouldReceive('createNew')
            ->once()
            ->with(Mockery::on(fn(Product $product) => $product->is($newProduct)))
            ->andReturnNull();
    }

    protected function shouldSearchAllByNames(array $productNames, ?ProductCollection $return): void
    {
        $this->shouldMakeProductQueryBuilder();
        $this->productQueryBuilder()
            ->shouldReceive('searchAllByNames')
            ->once()
            ->with($productNames)
            ->andReturn($return);
    }

    protected function shouldFindShop(string $shopId, ?Shop $shop): void
    {
        $this->shopFinder()
            ->shouldReceive('__invoke')
            ->with($shopId)
            ->andReturn($shop);
    }

    protected function shouldThrowShopNotExistsExceptionWhenFindShop(string $shopId): void
    {
        $this->shopFinder()
            ->shouldReceive('__invoke')
            ->with($shopId)
            ->andThrow(ShopNotExistsException::class);
    }

    protected function shouldNotFoundProductsByNames(array $productNames): void
    {
        $this->shouldSearchAllByNames($productNames, new ProductCollection());
    }

    protected function shouldFoundProductsByNames(array $productNames, ?ProductCollection $return): void
    {
        $this->shouldSearchAllByNames($productNames, $return);
    }

    protected function shouldCreateNewManyProduct(array $products): void
    {
        $this->shouldMakeProductQueryBuilder();
        $this->productQueryBuilder()
            ->shouldReceive('createNew')
            ->twice()
            ->with(Mockery::on(fn(Product $product) => in_array($product, $products)))
            ->andReturnNull();
    }

    protected function shouldCreateNewManyShopProduct(ShopProductData ...$shopProductData): void
    {
        $this->shopProductCreator()
            ->shouldReceive('__invoke')
            ->withArgs(function(ShopProductData ...$newShopProductData)use($shopProductData){
                return $newShopProductData == $shopProductData;
            })
            ->andReturnNull();
    }
}
