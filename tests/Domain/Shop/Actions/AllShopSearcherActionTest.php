<?php

declare(strict_types=1);

namespace Tests\Domain\Shop\Actions;

use Domain\Shop\Shop;
use Domain\Shop\Collections\ShopCollection;
use Tests\Domain\Shop\ShopModuleUnitTestCase;
use Domain\Shop\Actions\AllShopSearcherAction;

class AllShopSearcherActionTest extends ShopModuleUnitTestCase
{
    private readonly AllShopSearcherAction $searcher;

    public function setUp(): void
    {
        parent::setUp();
        $this->searcher = new AllShopSearcherAction($this->shopModel());
    }

    public function testShouldGetShopCollection(): void
    {
        /** @var ShopCollection $shops */
        $shops = Shop::factory()->count(1)->make();

        $this->shouldGetShopCollection($shops);

        $response = $this->searcher->__invoke();

        $this->assertEquals($shops, $response);
    }
}
