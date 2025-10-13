<?php

use Illuminate\Support\Facades\Route;

// Подключаем старые маршруты под namespace старых контроллеров
Route::group(['namespace' => 'App\\Http\\Controllers'], function () {
    require __DIR__.'/web_old.php';
});

// Совместимость с навигацией (Breeze): маршрут dashboard
Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
