<?php

namespace Domain\Shop\Resources;

use Domain\Product\Collections\ProductCollection;
use Domain\Product\Resources\ProductResource;
use Domain\Shop\Shop;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'product_count' => $this->getProductCount(),
            'products' => ProductResource::collection($this->getProducts()),
        ];
    }
}
