<?php

declare(strict_types=1);

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Support\Facades\Route;
use Nova\Foundation\Actions\OptimizeOrRepairDatabase;
use Nova\Foundation\Application;
use Nova\Foundation\Http\Middleware\CheckAddonAndThemeVersions;
use Nova\Foundation\Http\Middleware\CheckExternalContentCache;
use Nova\Foundation\Http\Middleware\CheckInstallStatus;
use Nova\Foundation\Http\Middleware\CheckNovaVersion;

$app = Application::configure(basePath: dirname(__DIR__, 2))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            if (app()->environment('local')) {
                Route::prefix('test')
                    ->middleware('web')
                    ->group(nova_path('routes/local.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'installed' => CheckInstallStatus::class,
        ]);

        $middleware->replace(
            PreventRequestsDuringMaintenance::class,
            Nova\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class
        );

        $middleware->web(append: [
            CheckNovaVersion::class,
            CheckAddonAndThemeVersions::class,
            CheckExternalContentCache::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // /** @var Nova\Users\Models\User */
        // $user = Auth::user();

        // /** @var Illuminate\Http\Request */
        // $request = request();

        // $exceptions->context(fn () => [
        //     'user' => $user ? $user->name.':'.$user->id : null,
        //     'url' => $request->method().':'.$request->fullUrl(),
        // ]);

        // $exceptions->map(function (TokenMismatchException $e) {
        //     return ValidationException::withMessages([
        //         'global' => 'Your session has expired. Please try again.',
        //     ]);
        // });
    })
    ->withCommands([
        OptimizeOrRepairDatabase::class,
    ])
    ->create();

if (! $app instanceof Application) {
    throw new LogicException('Expected the Nova application instance.');
}

$app->useNovaPath(path: $app->basePath('nova'));

$app->useAppPath(path: $app->novaPath('src'));
$app->useConfigPath(path: $app->novaPath('config'));
$app->useDatabasePath(path: $app->novaPath('database'));
$app->useAddonPath(path: $app->basePath('addons'));
$app->useLangPath(path: $app->novaPath('lang'));
$app->useThemePath(path: $app->basePath('themes'));
$app->useRankPath(path: $app->basePath('ranks'));

return $app;
