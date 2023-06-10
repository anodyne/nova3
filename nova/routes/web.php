<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Users\Models\User;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb}($page->uri, $page->resource)->name($page->key)
    );
} catch (Exception $ex) {
    // We're not going to do anything here yet
}

Route::get('test', function () {
    $user = User::first();

    dd(User::query()->whereHas('latestPost', fn ($query) => $query->where('published_at', '<', now()->addDays(2)))->dd()->get());

    dump($user->latestPost()->toSql());
    dump(data_get($user->latestPost, '0.title'));

    return 'done';
});
