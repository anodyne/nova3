<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Foundation\Http\Middleware\CheckInstallStatus;
use Nova\Pages\Controllers\BasicPageController;
use Nova\Pages\Controllers\PreviewBasicPageController;
use Nova\Pages\Models\Page;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Models\Page::get());

    $pages->basic()->each(function (Page $page) use ($router) {
        return $router->get($page->uri, BasicPageController::class)
            ->name($page->key)
            ->middleware($page->middleware);
    });

    $router->get('preview-page/{pageKey}', PreviewBasicPageController::class)->name('preview-basic-page');

    $pages->advanced()->each(function (Page $page) use ($router) {
        return $router->{$page->verb->value}($page->uri, $page->resource)
            ->name($page->key)
            ->middleware($page->middleware);
    });
} catch (Throwable $th) {
    Route::view('/', 'pages.welcome')->middleware(CheckInstallStatus::class);
}

Route::impersonate();
