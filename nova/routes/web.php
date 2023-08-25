<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Route;
use Nova\Stories\Models\Story;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Models\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb->value}($page->uri, $page->resource)->name($page->key)
    );
} catch (Throwable $th) {
    Route::view('/', 'pages.welcome');
}

Route::impersonate();

Route::get('test', function () {
    // dd(Date::createFromFormat('Y-m-d H:i:s', '2005-02-21 19:00:00', 'America/New_York'));
    // $now = Date::now('America/New_York');
    $date = Date::createFromFormat('Y-m-d H:i:s', '2005-02-21 19:00:00', 'America/New_York');

    // dd($date);

    // $story = Story::create([
    //     'title' => 'Test',
    //     'started_at' => $now,
    // ]);

    $story = Story::find(6);
    // $story->update(['started_at' => $date]);

    dd(
        $story->started_at,
        $story->ended_at
        // CarbonImmutable::parse($story->started_at)->setTimezone('America/New_York')
    );

    dd($story->started_at);

    return 'done';
});
