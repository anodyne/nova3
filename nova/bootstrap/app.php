<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Nova\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__, 2)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Nova\Foundation\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Nova\Foundation\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Nova\Foundation\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Bind Updated Paths
|--------------------------------------------------------------------------
|
| Next, we need to bind the updated paths into the container so we will be
| able to resolve them when needed.
|
*/

$app->useNovaPath(path: $app->basePath('nova'));

$app->useAppPath(path: $app->novaPath('src'));
$app->useBootstrapPath(path: $app->novaPath('bootstrap'));
$app->useConfigPath(path: $app->novaPath('config'));
$app->useDatabasePath(path: $app->novaPath('database'));
$app->useExtensionPath(path: $app->basePath('extensions'));
$app->useLangPath(path: $app->novaPath('lang'));
$app->useThemePath(path: $app->basePath('themes'));

if ($app->usesSimpleSkeleton()) {
    $app->usePublicPath(path: $app->basePath());
}

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
