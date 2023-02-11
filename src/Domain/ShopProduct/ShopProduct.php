<?php

declare(strict_types=1);

namespace Domain\ShopProduct;

use Illuminate\Database\Eloquent\Model;
use Domain\ShopProduct\Factory\ShopProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Domain\ShopProduct\Queries\ShopProductQueryBuilder;
use Domain\ShopProduct\Collections\ShopProductCollection;

class ShopProduct extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'shop_id',
        'product_id',
        'count',
    ];

    public static function newFactory(): ShopProductFactory
    {
        return new ShopProductFactory();
    }

    public function newEloquentBuilder($query): ShopProductQueryBuilder
    {
        return new ShopProductQueryBuilder($query);
    }

    public function newCollection(array $models = []): ShopProductCollection
    {
        return new ShopProductCollection($models);
    }

    public function getShopId(): string
    {
        return $this->shop_id;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
