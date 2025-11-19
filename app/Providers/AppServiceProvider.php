<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Если сконфигурированный URL приложения использует https — форсируем https для генерации ссылок
        $appUrl = (string) config('app.url');
        if (stripos($appUrl, 'https://') === 0) {
            URL::forceScheme('https');
        }
    }
}
