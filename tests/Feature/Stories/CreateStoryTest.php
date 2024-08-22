<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Media\Livewire\UploadImage;
use Nova\Stories\Events\StoryCreated;
use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertGreaterThan;
use function PHPUnit\Framework\assertLessThan;

uses()->group('stories');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'story.create');
    });

    test('can view the create story page', function () {
        get(route('admin.stories.create'))->assertSuccessful();
    });

    test('can create a story', function () {
        Event::fake();

        $data = Story::factory()->upcoming()->make();

        from(route('admin.stories.create'))
            ->followingRedirects()
            ->post(route('admin.stories.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Story::class, $data->toArray());

        Event::assertDispatched(StoryCreated::class);
    });

    test('can create a story inside another story', function () {
        $data = Story::factory()->upcoming()->withParent()->make();

        from(route('admin.stories.create'))
            ->followingRedirects()
            ->post(route('admin.stories.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Story::class, $data->toArray());
    });

    test('can create a story before another story', function () {
        $existingStory = Story::factory()->create();

        $data = array_merge(
            Story::factory()->make()->toArray(),
            [
                'display_direction' => 'before',
                'display_neighbor' => $existingStory->id,
                'has_position_change' => true,
            ]
        );

        from(route('admin.stories.create'))
            ->followingRedirects()
            ->post(route('admin.stories.store'), $data)
            ->assertSuccessful();

        $existingStory->refresh();
        $createdStory = Story::where('title', $data['title'])->first();

        assertLessThan($existingStory->order_column, $createdStory->order_column);
    });

    test('can create a story after another story', function () {
        $existingStory = Story::factory()->create();

        $data = array_merge(
            Story::factory()->upcoming()->make()->toArray(),
            [
                'display_direction' => 'after',
                'display_neighbor' => $existingStory->id,
                'has_position_change' => true,
            ]
        );

        from(route('admin.stories.create'))
            ->followingRedirects()
            ->post(route('admin.stories.store'), $data)
            ->assertSuccessful();

        $existingStory->refresh();
        $createdStory = Story::where('title', $data['title'])->first();

        assertGreaterThan($existingStory->order_column, $createdStory->order_column);
    });

    test('can upload a story image when creating', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('story-image.png'))
            ->get('path');

        $data = array_merge(
            Story::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('admin.stories.create'))
            ->followingRedirects()
            ->post(route('admin.stories.store'), $data)
            ->assertSuccessful();

        $story = Story::where('title', $data['title'])->first();

        assertCount(1, $story->getMedia('story-image'));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create story page', function () {
        get(route('admin.stories.create'))->assertForbidden();
    });

    test('cannot create a story', function () {
        $data = Story::factory()->make();

        post(route('admin.stories.store'), $data->toArray())->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create story page', function () {
        get(route('admin.stories.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a story', function () {
        post(route('admin.stories.store'), [])
            ->assertRedirectToRoute('login');
    });
});
