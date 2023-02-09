<?php

declare(strict_types=1);

namespace Tests\Domain\Shop;

use Domain\Shop\Queries\ShopQueryBuilder;
use Domain\Shop\Shop;
use Mockery\MockInterface;
use Tests\UnitTestCase;

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
}
