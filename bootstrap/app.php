<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'autocutoff' => \App\Http\Middleware\AutoCutOff::class,
        ]);
        // CSRF Exception dihapus karena webhook sudah pindah ke api.php (otomatis bypass)
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
