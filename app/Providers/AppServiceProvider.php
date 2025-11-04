<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

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
        // Share jumlah item cart ke semua view
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
            } else {
                $cartCount = 0;
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
