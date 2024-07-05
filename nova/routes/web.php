<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Forms\Models\Form;
use Nova\Foundation\Http\Middleware\CheckInstallStatus;
use Nova\Pages\Controllers\BasicPageController;
use Nova\Pages\Controllers\PreviewBasicPageController;
use Nova\Pages\Models\Page;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Models\Page::get());

    $pages->basic()->each(
        fn (Page $page) => $router->get($page->uri, BasicPageController::class)->name($page->key)
    );

    $router->get('preview-page/{pageKey}', PreviewBasicPageController::class)->name('preview-basic-page');

    $pages->advanced()->each(
        fn (Page $page) => $router->{$page->verb->value}($page->uri, $page->resource)->name($page->key)
    );
} catch (Throwable $th) {
    Route::view('/', 'pages.welcome')->middleware(CheckInstallStatus::class);
}

Route::impersonate();
