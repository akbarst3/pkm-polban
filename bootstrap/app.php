<?php

use App\Http\Middleware\OpAuth;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\OperatorRedirectIfAuthenticated;
use Illuminate\Session\Middleware\StartSession;

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
            'session.timeout' => SessionTimeout::class
        ]);
        $middleware->prependToGroup('web', StartSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
