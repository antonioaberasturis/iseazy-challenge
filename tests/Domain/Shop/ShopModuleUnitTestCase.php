<?php

declare(strict_types=1);

namespace Tests\Domain\Shop;

use Mockery;
use Domain\Shop\Shop;
use Tests\UnitTestCase;
use Mockery\MockInterface;
use Domain\Shop\Queries\ShopQueryBuilder;

abstract class ShopModuleUnitTestCase extends UnitTestCase
{
    protected Shop $shop;
    protected ShopQueryBuilder $queryBuilder;

    protected function shopModel(): MockInterface|Shop
    {
        return $this->shop = $this->shop ?? $this->partialMock(Shop::class);
    }

    protected function shopQueryBuilder(): MockInterface|ShopQueryBuilder
    {
        return $this->queryBuilder = $this->queryBuilder ?? $this->mock(ShopQueryBuilder::class);
    }

    public function shouldMakeShopQueryBuilder(): void
    {
        $this->shopModel()
        ->shouldReceive('query')
        ->withNoArgs()
        ->andReturn($this->shopQueryBuilder());
    }

    protected function shouldGetShopCollection($return): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('searchAllShop')
            ->once()
            ->withNoArgs()
            ->andReturn($return);
    }

    protected function shouldCreateNewShop(Shop $newShop): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('createNew')
            ->once()
            ->with(Mockery::on(fn(Shop $shop) => $shop->is($newShop)))
            ->andReturnNull();
    }

    protected function shouldSearchShopByName(string $shopName, ?Shop $return): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('searchByName')
            ->once()
            ->with($shopName)
            ->andReturn($return);
    }

    protected function shouldNotSearchShopByName(string $shopName): void
    {
        $this->shouldSearchShopByName($shopName, null);
    }

    protected function shouldFindShop(string $id, ?Shop $return): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($return);
    }

    protected function shouldNotFindShop(string $id): void
    {
        $this->shouldFindShop($id, null);
    }

    protected function shouldUpdateShop(Shop $shop): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('updateShop')
            ->once()
            ->with(Mockery::on(fn(Shop $shop) => $shop->is($shop)))
            ->andReturnNull();
    }
}
