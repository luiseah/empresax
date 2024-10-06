<?php

namespace Tests\Managers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait ProductManager
{
    /**
     * Create a new user.
     *
     * @param array<string, mixed> $attributes
     * @return Product
     */
    public function createProduct(array $attributes = []): Product
    {
        return Product::factory()
            ->createOne($attributes);
    }

    /**
     * Create a new user.
     *
     * @param mixed $array
     * @param int $count
     * @return Collection<int, Product>
     */
    public function createManyProducts(mixed $array = [], int $count = 10): Collection
    {
        $has = fn($index) => is_array($array) && array_is_list($array)
            ? $array[$index]
            : $array ?? [];

        return Collection::make(array_fill(0, $count, null))
            ->map(fn($value, $index) => $this->createProduct($has($index)));
    }
}
