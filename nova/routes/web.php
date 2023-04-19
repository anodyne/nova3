<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Stories\Models\Story;

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb}($page->uri, $page->resource)->name($page->key)
    );
} catch (Exception $ex) {
    // We're not going to do anything here yet
}

Route::get('test', function () {
    $stories = Story::tree()
        ->withCount('posts', 'recursivePosts')
        ->orderBy('sort')
        ->get();

    // foreach ($stories as $story) {
    // 	dump($story->title, $story->children);
    // }

    dump($stories->toTree()->toArray());

    return 'done';
});
