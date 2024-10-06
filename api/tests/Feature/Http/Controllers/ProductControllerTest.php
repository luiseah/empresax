<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\ProductStatusEnum;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * Test a Product can be indexed by guest
     */
    public function test_a_product_can_be_indexed_by_guest(): void
    {
        $attributes = [
            'name' => 'Product # 1',
            'status' => ProductStatusEnum::Active,
            'price' => 10.5,
            'stock' => 10,
            'ean_13' => '1234567890123'
        ];

        $this->createProduct($attributes);

        $rows = 1;

        $this->assertGuest();

        /**
         * @see ProductController::index
         */
        $this->get(route('products.index'))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasAll('data', 'status', 'message')
                ->whereAll([
                    'status' => 'success',
                    'message' => null,
                ])
                ->has('data', $rows, fn(AssertableJson $json) => $json
                    ->hasAll(
                        'id',
                        'name',
                        'status',
                        'price',
                        'stock',
                        'ean_13',
                        'user_id',
                        'created_at',
                        'updated_at',
                    )
                    ->whereAll([
                        'name' => $attributes['name'],
                        'status' => $attributes['status'],
                        'price' => $attributes['price'],
                        'stock' => $attributes['stock'],
                        'ean_13' => $attributes['ean_13'],
                    ])
                )
            );
    }

    /**
     * Test a Product can be indexed
     */
    public function test_a_product_can_be_index(): void
    {
        $user = $this->createUser();
        Sanctum::actingAs($user, ['view any ingredient', '*']);

        $attributes = [
            'name' => 'Product # 1',
            'status' => ProductStatusEnum::Active,
            'price' => 10.5,
            'stock' => 10,
            'ean_13' => '1234567890123'
        ];

        $this->createProduct($attributes);

        $rows = 10;

        $this->createManyProducts([], 9);

        $this->assertDatabaseCount(Product::class, $rows);

        $this->assertAuthenticated();

        /**
         * @see ProductController::index
         */
        $this->get(route('products.index'))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasAll('data', 'status', 'message')
                ->whereAll([
                    'status' => 'success',
                    'message' => null,
                ])
                ->has('data', $rows, fn(AssertableJson $json) => $json
                    ->hasAll(
                        'id',
                        'name',
                        'status',
                        'price',
                        'stock',
                        'ean_13',
                        'user_id',
                        'created_at',
                        'updated_at',
                    )
                    ->whereAll([
                        'name' => $attributes['name'],
                        'status' => $attributes['status'],
                        'price' => $attributes['price'],
                        'stock' => $attributes['stock'],
                        'ean_13' => $attributes['ean_13'],
                    ])
                )
            );
    }
}
