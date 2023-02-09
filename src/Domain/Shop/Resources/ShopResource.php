<?php

declare(strict_types=1);

namespace Domain\Shop\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public function toArray($request = null)
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'product_count' => $this->getProductCount(),
        ];
    }
}
