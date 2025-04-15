<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mchev\Banhammer\Middleware\IPBanned;
use Nova\Foundation\Http\Middleware\CheckInstallStatus;
use Nova\Foundation\Http\Middleware\LogoutBanned;
use Nova\Pages\Actions\RecachePages;
use Nova\Pages\Controllers\BasicPageController;
use Nova\Pages\Controllers\PreviewBasicPageController;
use Nova\Pages\Models\Page;

try {
    RecachePages::run();

    $basicPages = cache('nova.basic-pages');

    $basicPages->each(function (Page $page) use ($router) {
        return $router->get($page->uri, BasicPageController::class)
            ->name($page->key)
            ->middleware(array_merge(
                $page->middleware ?? [],
                [
                    LogoutBanned::class,
                    IPBanned::class,
                ]
            ));
    });

    $router->get('preview-page/{pageKey}', PreviewBasicPageController::class)
        ->name('preview-basic-page')
        ->middleware([
            LogoutBanned::class,
            IPBanned::class,
        ]);

    $advancedPages = cache('nova.advanced-pages');

    $advancedPages->each(function (Page $page) use ($router) {
        return $router->{$page->verb->value}($page->uri, $page->resource)
            ->name($page->key)
            ->middleware(array_merge(
                $page->middleware ?? [],
                [
                    LogoutBanned::class,
                    IPBanned::class,
                ]
            ));
    });
} catch (Throwable $th) {
    Route::view('/', 'pages.welcome')->middleware(CheckInstallStatus::class);
}

Route::impersonate();
