<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Response::macro('api', function ($data, $message = null, $extra = [], $status = 200) {
            $attributes = $data instanceof \Illuminate\Pagination\LengthAwarePaginator
                ? [...$data->toArray()]
                : ['data' => $data];

            return \Response::json([
                ...$attributes,
                'message' => $message,
                'status' => 'success',
                ...$extra
            ], $status);
        });

        \Response::macro('success', function ($message, $extra = [], $status = 200) {
            return \Response::json([
                'message' => $message,
                'status' => 'success',
                ...$extra
            ], $status);
        });

        \Response::macro('error', function ($message, $extra = [], $status = 400) {
            return \Response::json([
                'message' => $message,
                'status' => 'success',
                ...$extra
            ], $status);
        });
    }
}
