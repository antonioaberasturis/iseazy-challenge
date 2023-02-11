<?php

declare(strict_types=1);

namespace Domain\Product\DataTransferObjects;

class ProductsData
{
    private array $products;
    
    public function __construct(
        array $products,
    ) {
        $this->products = array_map(fn(array $product) => 
                                new ProductData(
                                    id:     $product['id'],
                                    name:   $product['name'],
                                    count:  $product['count'],
                                ), 
                                $products);
    }

    public function toArray(): array
    {
        return $this->products;
    }
}
