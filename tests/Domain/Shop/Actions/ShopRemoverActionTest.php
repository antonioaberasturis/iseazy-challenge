<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Product\Product;
use Domain\ShopProduct\ShopProduct;
use Domain\Shop\Actions\ShopFinderAction;
use Domain\Shop\Actions\ShopRemoverAction;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Domain\ShopProduct\Collections\ShopProductCollection;

class ShopRemoverActionTest extends ShopModuleUnitTestCase
{
    private ShopRemoverAction $remover;

    public function setUp(): void
    {
        parent::setUp();
        $this->remover = new ShopRemoverAction(
                            $this->shopModel(),
                            new ShopFinderAction(
                                $this->shopModel()
                            ),
                            $this->shopProductSearcher(),
                            $this->shopProductRemover(),
                            $this->productRemoverByIds()
        );
    }

    public function testShouldRemoveShopWithProducts(): void
    {
        /** @var Shop $shop */
        $shop = Shop::factory()->make();
        /** @var Product $product */
        $product = Product::factory()->make();
        /** @var ShopProduct $shopProduct */
        $shopProduct = ShopProduct::factory()
                                    ->shopId($shop->getId())
                                    ->productId($product->getId())
                                    ->make();
        /** @var ShopProductCollection $shopProducts */
        $shopProducts = new ShopProductCollection([$shopProduct]);

        $this->shouldFindShop($shop->getId(), $shop);
        $this->shouldSearchShopProducts($shop->getId(), $shopProducts);
        $this->shouldRemoveShopProducts($shop->getId());
        $this->shouldRemoveProductByIds([$product->getId()]);
        $this->shouldRemoveShop($shop);

        $this->remover->__invoke($shop->getId());
    }
}
