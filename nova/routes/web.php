<?php

declare(strict_types=1);

try {
    $pages = cache()->rememberForever('nova.pages', fn () => Nova\Pages\Page::get());

    $pages->each(
        fn ($page) => $router->{$page->verb}($page->uri, $page->resource)->name($page->key)
    );
} catch (Exception $ex) {
    // We're not going to do anything here yet
}
