<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    // ... (semua konfigurasi dari 'name' hingga 'maintenance' tidak berubah) ...
    'name' => env('APP_NAME', 'Laravel'),
    'env' => env('APP_ENV', 'production'),
    // ...
    'maintenance' => [
        'driver' => 'file',
        'store'  => 'database',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */
    'providers' => ServiceProvider::defaultProviders()->merge([
        // ...
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        
        // PASTIKAN HANYA ADA SATU PROVIDER PDF, YAITU SNAPPY
        Barryvdh\Snappy\ServiceProvider::class,

    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    */
    'aliases' => Facade::defaultAliases()->merge([
        // ...
        
        // PERUBAHAN DI SINI: Alias PDF sekarang menunjuk ke Snappy
        'PDF' => Barryvdh\Snappy\Facades\Pdf::class,

    ])->toArray(),
];