<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Notes\Data\NoteData;
use Nova\Users\Models\User;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb}($page->uri, $page->resource)->name($page->key)
    );

    Route::get('auto-login/{user:email}', function ($email = 'admin@admin.com') {
        abort_unless(app()->environment('local'), 403);

        auth()->login(User::whereEmail($email)->first());

        return redirect()->route('dashboard');
    })->name('dev-login');

    Route::get('laravel-data', function () {
        $data = new NoteData(
            title: 'My title',
            content: 'My content',
            summary: 'My summary',
            user: User::first(),
        );

        $data->only('title');

        $data->all();

        // dd($data, $data->all(), $data->toArray());
    });
} catch (Exception $ex) {
    // We're not going to do anything here yet
}
