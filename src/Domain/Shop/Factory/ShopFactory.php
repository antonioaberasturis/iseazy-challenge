<?php

declare(strict_types=1);

namespace Domain\Shop\Factory;

use Domain\Shop\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShopFactory extends Factory
{
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'product_count' => $this->faker->numberBetween(1),
        ];
    }

    public function id(?string $id): static
    {
        return $this->state(fn(array $attributes) => [
                'id' => $id ?? $attributes['id'],
        ]);
    }

    public function name(?string $name): static
    {
        return $this->state(fn(array $attributes) => [
                'name' => $name ?? $attributes['name'],
        ]);
    }

    public function productCount(?int $productCount): static
    {
        return $this->state(fn(array $attributes) => [
                'product_count' => $productCount ?? $attributes['product_count'],
        ]);
    }
}
