<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Подключение пользовательских хелперов на ранней стадии
if (file_exists(__DIR__.'/../app/Support/helpers.php')) {
    require_once __DIR__.'/../app/Support/helpers.php';
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'make-statistic' => \App\Http\Middleware\makeStatistic::class,
            'get-statistic' => \App\Http\Middleware\getStatistic::class,
            'get-status' => \App\Http\Middleware\getStatuses::class,
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'is-cooperative' => \App\Http\Middleware\isCooperativeUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
