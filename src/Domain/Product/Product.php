<?php

declare(strict_types=1);

namespace Domain\Product;

use Illuminate\Database\Eloquent\Model;
use Domain\Product\Factory\ProductFactory;
use Domain\Product\Queries\ProductQueryBuilder;
use Domain\Product\Collections\ProductCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public static function newFactory(): ProductFactory
    {
        return new ProductFactory();
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public function newCollection(array $models = []): ProductCollection
    {
        return new ProductCollection($models);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
