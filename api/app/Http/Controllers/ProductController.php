<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexProductRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(IndexProductRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::applyFilters($request)
            ->pagination();

        return \Response::api($products);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreProductRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();

        $product = $user->products()->create($request->validated());

        return \Response::api($product, __('Product created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Product $product): JsonResponse
    {
        $this->authorize('view', $product);

        return \Response::api($product);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return \Response::api($product->refresh(), __('Product updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return \Response::success(__('Product deleted successfully.'));
    }
}
