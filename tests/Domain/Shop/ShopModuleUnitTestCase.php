<?php

declare(strict_types=1);

namespace Tests\Domain\Shop;

use Mockery;
use Domain\Shop\Shop;
use Tests\UnitTestCase;
use Mockery\MockInterface;
use Domain\Shop\Queries\ShopQueryBuilder;
use Domain\Product\Actions\ProductRemoverByIdsAction;
use Domain\ShopProduct\Actions\ShopProductRemoverAction;
use Domain\ShopProduct\Actions\ShopProductSearcherAction;
use Domain\ShopProduct\Collections\ShopProductCollection;

abstract class ShopModuleUnitTestCase extends UnitTestCase
{
    protected Shop $shop;
    protected ShopQueryBuilder $queryBuilder;
    protected ShopProductRemoverAction $shopProductRemover;
    protected ShopProductSearcherAction $shopProductSearcher;
    protected ProductRemoverByIdsAction $productRemoverByIds;

    protected function shopModel(): MockInterface|Shop
    {
        return $this->shop = $this->shop ?? $this->partialMock(Shop::class);
    }

    protected function shopQueryBuilder(): MockInterface|ShopQueryBuilder
    {
        return $this->queryBuilder = $this->queryBuilder ?? $this->mock(ShopQueryBuilder::class);
    }

    protected function shopProductRemover(): MockInterface|ShopProductRemoverAction
    {
        return $this->shopProductRemover = $this->shopProductRemover ?? $this->mock(ShopProductRemoverAction::class);
    }

    protected function shopProductSearcher(): MockInterface|ShopProductSearcherAction
    {
        return $this->shopProductSearcher = $this->shopProductSearcher ?? $this->mock(ShopProductSearcherAction::class);
    }

    protected function productRemoverByIds(): MockInterface|ProductRemoverByIdsAction
    {
        return $this->productRemoverByIds = $this->productRemoverByIds ?? $this->mock(ProductRemoverByIdsAction::class);
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

    protected function shouldLoadProducts(Shop $shop): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('loadProducts')
            ->once()
            ->with(Mockery::on(fn(Shop $shop) => $shop->is($shop)))
            ->andReturn($shop);
    }

    protected function shouldSearchShopProducts(string $shopId, ShopProductCollection $return): void
    {
        $this->shopProductSearcher()
            ->shouldReceive('__invoke')
            ->once()
            ->with($shopId)
            ->andReturn($return);
    }

    protected function shouldRemoveShopProducts(string $shopId): void
    {
        $this->shopProductRemover()
            ->shouldReceive('__invoke')
            ->once()
            ->with($shopId)
            ->andReturnNull();
    }

    protected function shouldRemoveProductByIds(array $productIds): void
    {
        $this->productRemoverByIds()
            ->shouldReceive('__invoke')
            ->once()
            ->with($productIds)
            ->andReturnNull();
    }

    protected function shouldRemoveShop(Shop $shop): void
    {
        $this->shouldMakeShopQueryBuilder();
        $this->shopQueryBuilder()
            ->shouldReceive('deleteShop')
            ->once()
            ->with($shop)
            ->andReturnNull();
    }
}
