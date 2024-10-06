<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index(Request $request): JsonResponse
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();

        $user->validateCart();

        return \Response::api($user->cart?->load('items'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreCartRequest $request): JsonResponse
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();

        $data = $request->collect('products')
            ->mapWithKeys(function ($product) {
                $productId = data_get($product, 'product_id');
                $quantity = data_get($product, 'quantity');

                /**
                 * @var \App\Models\Product $model
                 */
                $model = Product::findOrFail($productId);
                $subTotal = $model->price * $quantity;

                return [
                    $productId => [
                        'quantity' => $quantity,
                        'subtotal' => $subTotal,
                        'iva' => $subTotal * Config::get('products.iva')
                    ]
                ];
            })->toArray();

        $user->validateCart();

        $user->cart?->items()->sync($data);

        $user->cart?->load('items');

        return \Response::api($user->cart, __('Product added to cart successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart): JsonResponse
    {
        return \Response::api($cart->load('items'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart): JsonResponse
    {
        $cart->items()->detach();

        return \Response::api(null, __('Cart cleared successfully.'));
    }
}
