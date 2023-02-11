<?php

declare(strict_types=1);

namespace Tests\Domain\ShopProduct\Queries;

use Domain\Product\Product;
use Domain\Shop\Shop;
use Domain\ShopProduct\ShopProduct;
use Tests\Domain\ShopProduct\ShopProductModuleIntegrationTestCase;

class ShopProductQueryBuilderTest extends ShopProductModuleIntegrationTestCase
{
    public function testShouldCreateNewManyShopProduct(): void
    {
        $shop           = Shop::factory()->create();
        $product        = Product::factory()->create();
        $shopProduct   = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($product->getId())
                                    ->make();

        (new ShopProduct)->query()->createNewMany(...[$shopProduct]);

        $this->assertDatabaseHas((new ShopProduct)->getTable(), $shopProduct->toArray());
    }
}
