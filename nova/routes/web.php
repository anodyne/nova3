<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\PostTypes\Data\Options;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb}($page->uri, $page->resource)->name($page->key)
    );
} catch (Exception $ex) {
    // We're not going to do anything here yet
}

Route::get('test', function () {
    $options = [
        'notifiesUsers' => 'true',
        'includedInPostTracking' => 'true',
        'allowsMultipleAuthors' => 'true',
        'allowsCharacterAuthors' => 'true',
        'allowsUserAuthors' => 'true',
    ];

    dd(Options::from($options));

    return 'done';
});
