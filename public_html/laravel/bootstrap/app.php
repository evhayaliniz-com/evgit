<?php

use App\Http\Middleware\UpdateUserLastSeen;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\UserTypeMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user.type' => \App\Http\Middleware\UserTypeMiddleware::class,
            'checkUserType' => \App\Http\Middleware\CheckUserType::class,
            'lastSeen' => \App\Http\Middleware\UpdateUserLastSeen::class,
            'isCompanyCompleted' => \App\Http\Middleware\IsCompanyCompletedMiddleware::class,
            'cache.images' => \App\Http\Middleware\CacheImages::class,
        ]);

        // Görseller için global middleware ekle
        $middleware->web(append: [
            \App\Http\Middleware\CacheImages::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // Her gün saat 01:00'de süresi dolan paketleri ve servislerini pasif yap
        $schedule->command('packages:deactivate-expired')
            ->dailyAt('01:00')
            ->withoutOverlapping()
            ->onOneServer();

        // Her gün saat 02:00'de otomatik yenileme aktif olan paketleri yenile
        $schedule->command('packages:renew-expired')
            ->dailyAt('02:00')
            ->withoutOverlapping()
            ->onOneServer();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
