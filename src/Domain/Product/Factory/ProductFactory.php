<?php

declare(strict_types=1);

namespace Domain\Product\Factory;

use Domain\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

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
}
