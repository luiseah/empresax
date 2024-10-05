<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexProductRequest $request)
    {
        //$this->authorize('viewAny', Product::class);

        $products = Product::applyFilters($request)
            ->pagination();

        return \Response::api($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //$this->authorize('store', Product::class);

        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();

        $product = $user->products()->create($request->validated());

        return \Response::api($product,__('Product created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //$this->authorize('view', $product);

        return \Response::api($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //$this->authorize('update', $product);

        $product->update($request->validated());

        return \Response::api($product->refresh(),__('Product updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //$this->authorize('delete', $product);

        $product->delete();

        return \Response::success(__('Product deleted successfully.'));
    }
}
