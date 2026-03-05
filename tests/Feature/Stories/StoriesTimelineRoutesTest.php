<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PublishedPostsList;
use Nova\Stories\Livewire\StoriesTimeline;

use function Pest\Laravel\get;

uses()->group('stories', 'storytelling');

describe('authenticated user', function () {
    beforeEach(function (): void {
        signIn();
    });

    test('can view posts timeline page', function (): void {
        get(route('admin.stories.posts-timeline'))
            ->assertSuccessful()
            ->assertSeeLivewire(PublishedPostsList::class);
    });

    test('can view stories timeline page', function (): void {
        get(route('admin.stories.stories-timeline'))
            ->assertSuccessful()
            ->assertSeeLivewire(StoriesTimeline::class);
    });
});

describe('unauthenticated user', function () {
    test('cannot view posts timeline page', function (): void {
        get(route('admin.stories.posts-timeline'))
            ->assertRedirectToRoute('login');
    });

    test('cannot view stories timeline page', function (): void {
        get(route('admin.stories.stories-timeline'))
            ->assertRedirectToRoute('login');
    });
});
