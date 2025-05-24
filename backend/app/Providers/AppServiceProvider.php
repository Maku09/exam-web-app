<?php

namespace App\Providers;

use App\Models\Product;
use App\Pagination\MyPaginator;
use App\Policies\ProductPolicy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->alias(MyPaginator::class, LengthAwarePaginator::class);
        $this->app->alias(MyPaginator::class, LengthAwarePaginatorContract::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Gate::policy(Product::class, ProductPolicy::class);
    }
}
