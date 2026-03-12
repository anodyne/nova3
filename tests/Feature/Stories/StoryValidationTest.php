<?php

declare(strict_types=1);

use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;

uses()->group('stories', 'storytelling');

describe('authorized user', function () {
    test('create story payload is validated', function (): void {
        signIn(permissions: 'story.create');

        from(route('admin.stories.create'))
            ->post(route('admin.stories.store'), [])
            ->assertSessionHasErrors(['title', 'status']);

        from(route('admin.stories.create'))
            ->post(route('admin.stories.store'), [
                'title' => 'A Valid Title',
                'status' => 'upcoming',
                'parent_id' => PHP_INT_MAX,
            ])
            ->assertSessionHasErrors(['parent_id']);

        from(route('admin.stories.create'))
            ->post(route('admin.stories.store'), [
                'title' => 'A Valid Title',
                'status' => 'upcoming',
                'display_direction' => 'sideways',
            ])
            ->assertSessionHasErrors(['display_direction']);
    });

    test('update story payload is validated', function (): void {
        signIn(permissions: 'story.update');

        $story = Story::factory()->create();

        from(route('admin.stories.edit', $story))
            ->put(route('admin.stories.update', $story), [])
            ->assertSessionHasErrors(['title', 'status']);

        from(route('admin.stories.edit', $story))
            ->put(route('admin.stories.update', $story), [
                'title' => 'A Valid Title',
                'status' => 'current',
                'parent_id' => PHP_INT_MAX,
            ])
            ->assertSessionHasErrors(['parent_id']);

        from(route('admin.stories.edit', $story))
            ->put(route('admin.stories.update', $story), [
                'title' => 'A Valid Title',
                'status' => 'current',
                'display_direction' => 'sideways',
            ])
            ->assertSessionHasErrors(['display_direction']);
    });

    test('create story accepts nullable fields', function (): void {
        signIn(permissions: 'story.create');

        $title = 'Nullable Create Story '.str()->random(10);

        from(route('admin.stories.create'))
            ->followingRedirects()
            ->post(route('admin.stories.store'), [
                'title' => $title,
                'status' => 'upcoming',
                'description' => null,
                'started_at' => null,
                'ended_at' => null,
                'summary' => null,
                'parent_id' => null,
                'display_direction' => null,
                'display_neighbor' => null,
            ])
            ->assertSuccessful();

        assertDatabaseHas(Story::class, [
            'title' => $title,
            'status' => 'upcoming',
            'description' => null,
            'started_at' => null,
            'ended_at' => null,
            'summary' => null,
            'parent_id' => null,
        ]);
    });

    test('update story accepts nullable fields', function (): void {
        signIn(permissions: 'story.update');

        $story = Story::factory()->upcoming()->create([
            'description' => 'Story description',
            'summary' => 'Story summary',
            'started_at' => null,
            'ended_at' => null,
            'parent_id' => Story::factory(),
        ]);

        from(route('admin.stories.edit', $story))
            ->followingRedirects()
            ->put(route('admin.stories.update', $story), [
                'title' => $story->title,
                'status' => 'upcoming',
                'description' => null,
                'started_at' => null,
                'ended_at' => null,
                'summary' => null,
                'parent_id' => null,
                'display_direction' => null,
                'display_neighbor' => null,
            ])
            ->assertSuccessful();

        assertDatabaseHas(Story::class, [
            'id' => $story->id,
            'title' => $story->title,
            'status' => 'upcoming',
            'description' => null,
            'started_at' => null,
            'ended_at' => null,
            'summary' => null,
            'parent_id' => null,
        ]);
    });
});
