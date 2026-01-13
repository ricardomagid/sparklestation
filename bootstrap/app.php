<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exceptions\DisambiguationRequiredException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
         $exceptions->render(function (DisambiguationRequiredException $e, $request) {
            session([
                'disambiguation' => [
                    'model' => $e->modelClass,
                    'matches' => $e->matches,
                    'search' => $e->search,
                    'routeKey' => $e->routeKey
                ]
            ]);

            return redirect()->route('disambiguation.show');
        });

        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 404) {
                return response()->view('errors.404', [
                    'entity'  => $e->getHeaders()['Entity'] ?? null
                ], 404);
            }
        });
    })->create();
