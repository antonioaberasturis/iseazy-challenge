<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\Actions\ShopFinderAction;
use Domain\Shop\Exceptions\ShopNotExistsException;
use Tests\Domain\Shop\ShopModuleUnitTestCase;

class ShopFinderActionTest extends ShopModuleUnitTestCase
{
    private readonly ShopFinderAction $finder;

    public function setUp(): void
    {
        parent::setUp();
        $this->finder = new ShopFinderAction($this->shopModel());
    }

    public function testShouldFindShop(): void
    {
        $shop = Shop::factory()->make();

        $this->shouldFindShop($shop->getId(), $shop);

        $response = $this->finder->__invoke($shop->getId());

        $this->assertEquals($shop, $response);
    }

    public function testShouldThrowExceptionWhenFindNotExistingShop(): void
    {
        $this->expectException(ShopNotExistsException::class);
        
        $shop = Shop::factory()->make();

        $this->shouldNotFindShop($shop->getId(), null);

        $this->finder->__invoke($shop->getId());
    }
}
