<?php

use App\Http\Middleware\OpAuth;
use App\Http\Middleware\CekSurat;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\OperatorRedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => OpAuth::class,
            'guest' => OperatorRedirectIfAuthenticated::class,
            'session.timeout' => SessionTimeout::class,
            'cek.surat' => CekSurat::class
        ]);
        $middleware->prependToGroup('web', StartSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
