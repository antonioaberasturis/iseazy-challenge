<?php

declare(strict_types=1);

namespace Domain\Shop;

use Domain\Shop\Factory\ShopFactory;
use Illuminate\Database\Eloquent\Model;
use Domain\Shop\Queries\ShopQueryBuilder;
use Domain\Shop\Collections\ShopCollection;
use Domain\Product\Collections\ProductCollection;
use Domain\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_products', 'shop_id', 'product_id');
    }

    public function getProducts(): ProductCollection
    {
        return $this->relationLoaded('products') ? $this->products : new ProductCollection();
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function incrementProductCount(int $count): void
    {
        $this->product_count += $count;
    }
}
