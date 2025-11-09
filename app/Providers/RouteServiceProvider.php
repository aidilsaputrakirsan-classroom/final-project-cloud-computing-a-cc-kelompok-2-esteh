<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path ke halaman utama setelah login.
     */
    public const HOME = '/dashboard';

    /**
     * Jalankan konfigurasi routing aplikasi.
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Route untuk web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Route untuk API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
