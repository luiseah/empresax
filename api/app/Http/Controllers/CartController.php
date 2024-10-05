<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();

        return \Response::api($user->cart->load('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();

        $data = $request->collect('products')
            ->mapWithKeys(function ($product) {
                $model = \App\Models\Product::find($product['product_id']);

                return [
                    $product['product_id'] => [
                        'quantity' => $product['quantity'],
                        'subtotal' => $model->price * $product['quantity'],
                        'iva' => $model->price * $product['quantity'] * Config::get('products.iva')
                    ]
                ];
            })->toArray();

        $user->cart->items()->sync($data);

        return \Response::api($user->cart->load('items'), __('Product added to cart successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
       return \Response::api($cart->load('items'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->items()->detach();

        return \Response::api(null, __('Cart cleared successfully.'));
    }
}
