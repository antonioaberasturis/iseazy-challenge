<?php

declare(strict_types=1);

namespace Domain\Product\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request = null)
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
        ];
    }
}
