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
    // public function boot(): void
    // {
    //     if ($this->app->environment('production')) {
    //         \URL::forceScheme('https');
    //     }
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // inject favicon ke adminlte head config setelah app boot (Request tersedia)
        config([
            'adminlte.head' => [
                '<link rel="icon" href="' . asset('favicon.ico') . '" type="image/x-icon" />',
                '<link rel="icon" type="image/png" sizes="96x96" href="' . asset('favicon/favicon-96x96.png') . '" />',
                '<link rel="icon" type="image/svg+xml" href="' . asset('favicon/favicon.svg') . '" />',
                '<link rel="shortcut icon" href="' . asset('favicon/favicon.ico') . '" />',
                '<link rel="apple-touch-icon" sizes="180x180" href="' . asset('favicon/apple-touch-icon.png') . '" />',
                '<meta name="theme-color" content="#343a40" />',
            ]
        ]);
        // avoid running session-dependent code in console/artisan context
        if (app()->runningInConsole()) {
            view()->composer('*', fn($view) => $view->with('anggota', null));
            return;
        }

        view()->composer('*', function ($view) {
            try {
                $anggotaId = session()->get('anggota_id');
                $anggota = $anggotaId ? \App\Models\Anggota::find($anggotaId) : null;
            } catch (\Throwable $e) {
                $anggota = null;
            }
            $view->with('anggota', $anggota);
        });
    }
}
