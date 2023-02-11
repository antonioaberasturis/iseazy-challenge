<?php

declare(strict_types=1);

namespace Domain\ShopProduct\Factory;

use Domain\ShopProduct\ShopProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShopProductFactory extends Factory
{
    protected $model = ShopProduct::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'shop_id' => $this->faker->uuid(),
            'product_id' => $this->faker->uuid(),
            'count' => $this->faker->numberBetween(1)
        ];
    }

    public function shopId(?string $id): static
    {
        return $this->state(fn(array $attributes) => [
                'shop_id' => $id ?? $attributes['shop_id'],
        ]);
    }

    public function productId(?string $id): static
    {
        return $this->state(fn(array $attributes) => [
                'product_id' => $id ?? $attributes['product_id'],
        ]);
    }

    public function productCount(?int $count): static
    {
        return $this->state(fn(array $attributes) => [
                'count' => $count ?? $attributes['count'],
        ]);
    }
}
