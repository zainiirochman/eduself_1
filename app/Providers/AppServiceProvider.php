<?php

namespace App\Providers;

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
        view()->composer('*', function ($view) {
            $anggota = session('anggota_id') ? \App\Models\Anggota::find(session('anggota_id')) : null;
            $view->with('anggota', $anggota);
        });
    }
}
