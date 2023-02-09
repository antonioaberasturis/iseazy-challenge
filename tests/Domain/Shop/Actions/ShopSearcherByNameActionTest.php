<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Tests\Domain\Shop\Factories\ShopDataFactory;
use Domain\Shop\Actions\ShopSearcherByNameAction;

class ShopSearcherByNameActionTest extends ShopModuleUnitTestCase
{
    private readonly ShopSearcherByNameAction $searcher;

    public function setUp(): void
    {
        parent::setUp();
        $this->searcher = new ShopSearcherByNameAction($this->shopModel());
    }

    public function testShouldSearchShopByName(): void
    {
        $shop = Shop::factory()->make();

        $this->shouldSearchShopByName($shop->getName(), $shop);

        $response = $this->searcher->__invoke($shop->getName());

        $this->assertEquals($shop, $response);
    }

    public function testShouldNotSearchShopByName(): void
    {
        $shop = Shop::factory()->make();

        $this->shouldSearchShopByName($shop->getName(), null);

        $this->assertNull($this->searcher->__invoke($shop->getName()));
    }
}
