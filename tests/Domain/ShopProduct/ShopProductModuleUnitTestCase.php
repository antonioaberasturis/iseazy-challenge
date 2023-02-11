<?php

declare(strict_types=1);

namespace Tests\Domain\ShopProduct;

use Mockery;
use Tests\TestCase;
use Mockery\MockInterface;
use Domain\ShopProduct\ShopProduct;
use Domain\ShopProduct\Queries\ShopProductQueryBuilder;

abstract class ShopProductModuleUnitTestCase extends TestCase
{
    protected ShopProduct $shopProduct;
    protected ShopProductQueryBuilder $queryBuilder;

    protected function shopProductModel(): MockInterface|ShopProduct
    {
        return $this->shopProduct = $this->shopProduct ?? $this->partialMock(ShopProduct::class);
    }

    protected function shopProductQueryBuilder(): MockInterface|ShopProductQueryBuilder
    {
        return $this->queryBuilder = $this->queryBuilder ?? $this->mock(ShopProductQueryBuilder::class);
    }

    public function shouldMakeShopProductQueryBuilder(): void
    {
        $this->shopProductModel()
            ->shouldReceive('query')
            ->withNoArgs()
            ->andReturn($this->shopProductQueryBuilder());
    }

    protected function shouldCreateNewManyShopProduct(ShopProduct ...$shopProducts): void
    {
        $this->shouldMakeShopProductQueryBuilder();
        $this->shopProductQueryBuilder()
            ->shouldReceive('createNewMany')
            ->once()
            ->withArgs(function(ShopProduct ...$newShopProducts)use($shopProducts){
                return $newShopProducts == $shopProducts;
            })
            ->andReturnNull();
    }
}
