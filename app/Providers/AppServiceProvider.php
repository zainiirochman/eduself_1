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
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     // avoid running session-dependent code in console/artisan context
    //     if (app()->runningInConsole()) {
    //         view()->composer('*', fn($view) => $view->with('anggota', null));
    //         return;
    //     }

    //     view()->composer('*', function ($view) {
    //         try {
    //             $anggotaId = session()->get('anggota_id');
    //             $anggota = $anggotaId ? \App\Models\Anggota::find($anggotaId) : null;
    //         } catch (\Throwable $e) {
    //             $anggota = null;
    //         }
    //         $view->with('anggota', $anggota);
    //     });
    // }
}
