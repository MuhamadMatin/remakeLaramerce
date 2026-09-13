<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
      HandleInertiaRequests::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
      // if (!app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [401, 402, 403, 404, 419, 429, 500, 503])) {
      if (!app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [401, 402, 403, 404, 419, 429, 500, 503])) {
        return Inertia::render('error', ['status' => $response->getStatusCode()])
          ->toResponse($request)
          ->setStatusCode($response->getStatusCode());
      }

      return $response;
    });
    $exceptions->shouldRenderJsonWhen(
      fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
    );
  })->create();
