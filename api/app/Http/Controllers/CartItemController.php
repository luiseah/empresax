<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    private function validateQuantity(Request $request): void
    {
        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'not_in:0',
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function quantity(Request $request, CartItem $item): JsonResponse
    {
        $this->validateQuantity($request);

        $quantity = $request->integer('quantity');

        $item->quantity + $quantity < 0
            ? $item->changeQuantity(0)
            : $item->changeQuantity($quantity);

        return \Response::api($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $item): JsonResponse
    {
        $item->delete();

        return \Response::api(null, __('Cart Item delete successfully.'));
    }
}
