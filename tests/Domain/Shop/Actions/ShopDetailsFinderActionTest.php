<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Domain\Shop\Actions\ShopDetailsFinderAction;
use Domain\Shop\Actions\ShopFinderAction;
use Domain\Shop\Exceptions\ShopNotExistsException;

class ShopDetailsFinderActionTest extends ShopModuleUnitTestCase
{
    private readonly ShopDetailsFinderAction $finder;

    public function setUp(): void
    {
        parent::setUp();
        $this->finder = new ShopDetailsFinderAction(
                                $this->shopModel(),
                                new ShopFinderAction(
                                    $this->shopModel()
                                )
        );
    }

    public function testShouldFindShopDetailWithProducts(): void
    {
        $products = Product::factory()->count(1)->make();
        $shop = Shop::factory()->make();
        $shop->setRelation('products', $products);

        $this->shouldFindShop($shop->getId(), $shop);
        $this->shouldLoadProducts($shop, $shop);

        $response = $this->finder->__invoke($shop->getId());

        $this->assertEquals($shop, $response);
        $this->assertEquals($shop->getProducts(), $products);
    }

    public function testShouldThrowShopNotExistsExceptionWhenFindNotExistingShopDetail(): void
    {
        $this->expectException(ShopNotExistsException::class);

        $products = Product::factory()->count(1)->make();
        $shop = Shop::factory()->make();
        $shop->setRelation('products', $products);

        $this->shouldNotFindShop($shop->getId());

        $this->finder->__invoke($shop->getId());
    }
}
