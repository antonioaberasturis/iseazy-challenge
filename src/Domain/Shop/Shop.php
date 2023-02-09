<?php

declare(strict_types=1);

namespace Domain\Shop;

use Domain\Shop\Factory\ShopFactory;
use Illuminate\Database\Eloquent\Model;
use Domain\Shop\Queries\ShopQueryBuilder;
use Domain\Shop\Collections\ShopCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'product_count',
    ];

    public static function newFactory(): ShopFactory
    {
        return new ShopFactory();
    }

    public function newEloquentBuilder($query): ShopQueryBuilder
    {
        return new ShopQueryBuilder($query);
    }

    public function newCollection(array $models = []): ShopCollection
    {
        return new ShopCollection($models);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductCount(): int
    {
        return $this->product_count;
    }
}
