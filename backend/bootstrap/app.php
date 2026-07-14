<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Helpers\ApiResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);

    })
    
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (ValidationException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    'Validation failed.',
                    422,
                    $e->errors()
                );
            }

        });

        $exceptions->render(function (AuthenticationException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    'Unauthenticated.',
                    401
                );
            }

        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    'Resource not found.',
                    404
                );
            }

        });

        $exceptions->render(function (HttpException $e, $request) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    $e->getMessage() ?: 'HTTP Error.',
                    $e->getStatusCode()
                );
            }

        });

        $exceptions->render(function (\Throwable $e, $request) {

            dd(get_class($e));

        });

    })->create();
