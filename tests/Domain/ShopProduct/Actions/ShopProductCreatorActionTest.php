<?php

declare(strict_types=1);

namespace Tests\Domain\ShopProduct\Actions;

use Domain\ShopProduct\ShopProduct;
use Domain\ShopProduct\Actions\ShopProductCreatorAction;
use Domain\ShopProduct\Collections\ShopProductCollection;
use Tests\Domain\ShopProduct\Factories\ShopProductFactory;
use Tests\Domain\ShopProduct\ShopProductModuleUnitTestCase;
use Tests\Domain\ShopProduct\Factories\ShopProductDataFactory;
use Tests\Domain\ShopProduct\Factories\ShopProductsDataFactory;

class ShopProductCreatorActionTest extends ShopProductModuleUnitTestCase
{
    private readonly ShopProductCreatorAction $creator;

    public function setUp(): void
    {
        parent::setUp();
        $this->creator = new ShopProductCreatorAction($this->shopProductModel());
    }

    public function testShouldCreateNewManyShopProduct(): void
    {
        $shopProductsData = ShopProductDataFactory::makeCount(2);
        $shopProducts = ShopProductFactory::makeFromShopProductsData(...$shopProductsData);
        $this->shouldCreateNewManyShopProduct(...$shopProducts);

        $this->creator->__invoke(...$shopProductsData);
    }
}
