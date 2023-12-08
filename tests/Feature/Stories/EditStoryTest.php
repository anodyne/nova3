<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Media\Livewire\UploadImage;
use Nova\Stories\Events\StoryUpdated;
use Nova\Stories\Models\Story;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('stories');

beforeEach(function () {
    $this->story = Story::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'story.update');
    });

    test('can view the edit story page', function () {
        get(route('stories.edit', $this->story))->assertSuccessful();
    });

    test('can update a story', function () {
        Event::fake();

        $data = Story::factory()->make();

        from(route('stories.edit', $this->story))
            ->followingRedirects()
            ->put(route('stories.update', $this->story), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Story::class, $data->toArray());

        Event::assertDispatched(StoryUpdated::class);
    });

    test('can add a story image', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('story-image.png'))
            ->get('path');

        $data = array_merge(
            Story::factory()->upcoming()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('stories.edit', $this->story))
            ->followingRedirects()
            ->put(route('stories.update', $this->story), $data)
            ->assertSuccessful();

        $this->story->refresh();

        assertCount(1, $this->story->getMedia('story-image'));
    });

    test('can remove an uploaded story image', function () {
    })->todo();

    test('can replace an uploaded story image', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('story-image.png'))
            ->get('path');

        $data = array_merge(
            Story::factory()->upcoming()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        assertCount(0, $this->story->getMedia('story-image'));

        from(route('stories.edit', $this->story))
            ->put(route('stories.update', $this->story), $data);

        $this->story->refresh();

        assertCount(1, $this->story->getMedia('story-image'));

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('story-image-2.png'))
            ->get('path');

        $data = array_merge(
            Story::factory()->upcoming()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('stories.edit', $this->story))
            ->followingRedirects()
            ->put(route('stories.update', $this->story), $data)
            ->assertSuccessful();

        $this->story->refresh();

        assertCount(1, $this->story->getMedia('story-image'));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit story page', function () {
        get(route('stories.edit', $this->story))->assertForbidden();
    });

    test('cannot update a story', function () {
        $data = Story::factory()->make();

        put(route('stories.update', $this->story), $data->toArray())->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit story page', function () {
        get(route('stories.edit', $this->story))
            ->assertRedirect(route('login'));
    });

    test('cannot update a story', function () {
        put(route('stories.update', $this->story), [])
            ->assertRedirect(route('login'));
    });
});
