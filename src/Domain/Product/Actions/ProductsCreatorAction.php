<?php

declare(strict_types=1);

namespace Domain\Product\Actions;

use Domain\Shop\Actions\ShopFinderAction;
use Domain\Product\DataTransferObjects\ProductData;
use Domain\Product\DataTransferObjects\ProductsData;
use Domain\ShopProduct\Actions\ShopProductCreatorAction;
use Domain\Product\Actions\ProductsSearcherByNamesAction;
use Domain\ShopProduct\DataTransferObjects\ShopProductData;
use Domain\ShopProduct\DataTransferObjects\ShopProductsData;
use Domain\Product\Exceptions\ProductSomeAlreadyExistsException;

class ProductsCreatorAction
{
    public function __construct(
        private ProductCreatorAction $productCreator,
        private ShopProductCreatorAction $shopProductCreator,
        private ProductsSearcherByNamesAction $searcherByNames,
        private ShopFinderAction $shopFinder,
    ) {
    }

    public function __invoke(string $shopId, ProductsData $productsData): void
    {
        $shop = $this->shopFinder->__invoke($shopId);

        $this->ensureProductsNotExists($productsData);

        foreach($productsData->toArray() as $productData){
            $this->productCreator->__invoke($productData);
        }

        $shopProductsData = [];
        foreach($productsData->toArray() as $productData){
            $shopProductsData[] = new ShopProductData(
                shopId:     $shopId,
                productId:  $productData->id(),
                count:      $productData->count(),
            );
        }

        $this->shopProductCreator->__invoke(...$shopProductsData);
    }

    private function ensureProductsNotExists(ProductsData $productsData): void
    {
        $names = array_map(fn(ProductData $productData) => 
                                $productData->name(), 
                                $productsData->toArray()
        );

        $products = $this->searcherByNames->__invoke($names);

        if($products->isNotEmpty()){
            throw new ProductSomeAlreadyExistsException();
        }
    }
}
