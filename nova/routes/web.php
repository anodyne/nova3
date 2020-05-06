<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Nova\Dashboard\Http\Controllers\DashboardTestController;
use Nova\Foundation\Http\Controllers\ProcessResponseController;

try {
    $pages = cache()->rememberForever('nova.pages', function () {
        return \Nova\Pages\Page::get();
    });

    $pages->each(function ($page) use ($router) {
        $router
            ->{$page->verb}($page->uri, $page->resource)
            ->name($page->key);
    });
} catch (Exception $ex) {
    // We're not going to do anything here yet
}

Route::get('/dashboard-test', DashboardTestController::class);

Route::get('process-response', ProcessResponseController::class);

Route::get('test', function () {
    Inertia::setRootView('app-client');

    return Inertia::render('Test');
});
