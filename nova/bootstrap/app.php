<?php

declare(strict_types=1);

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Nova\Foundation\Application;
use Nova\Foundation\Http\Middleware\CheckVersion;

$app = Application::configure(basePath: dirname(__DIR__, 2))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
        then: function () {
            if (app()->environment('local')) {
                Route::prefix('test')
                    ->middleware('web')
                    ->group(nova_path('routes/local.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'installed' => Nova\Foundation\Http\Middleware\CheckInstallStatus::class,
        ]);

        $middleware->web(append: [
            CheckVersion::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

$app->useNovaPath(path: $app->basePath('nova'));

$app->useAppPath(path: $app->novaPath('src'));
$app->useConfigPath(path: $app->novaPath('config'));
$app->useDatabasePath(path: $app->novaPath('database'));
$app->useExtensionPath(path: $app->basePath('extensions'));
$app->useLangPath(path: $app->novaPath('lang'));
$app->useThemePath(path: $app->basePath('themes'));

if ($app->usesSimpleSkeleton()) {
    $app->usePublicPath(path: $app->basePath());
}

return $app;
