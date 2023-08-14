<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Models\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb->value}($page->uri, $page->resource)->name($page->key)
    );
} catch (Exception $ex) {
    // We're not going to do anything here yet
}

Route::impersonate();

Route::get('test', function () {
    $user = User::first();
    $character = Character::find(6);

    // dd(User::query()->whereHas('latestPost', fn ($query) => $query->where('published_at', '<', now()->addDays(2)))->dd()->get());

    // dump($user->latestPost()->toSql());
    // dump(data_get($user->latestPost, '0.title'));

    // ray($user->primaryCharacter->each(fn ($c) => ray($c->toArray())));

    $user->primaryCharacter()
        ->wherePivot('character_id', '!=', $character->id)
        ->get()
        ->each(fn (Character $c) => $user->primaryCharacter()->updateExistingPivot($c->id, ['primary' => false]))
        ->refresh();

    ray($user->primaryCharacter->each(fn ($c) => ray($c->toArray())));

    return 'done';
});
