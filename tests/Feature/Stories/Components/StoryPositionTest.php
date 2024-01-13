<?php

declare(strict_types=1);

use Nova\Stories\Livewire\StoryPosition;
use Nova\Stories\Models\Story;

use function Pest\Livewire\livewire;

uses()->group('stories');
uses()->group('components');

beforeEach(function () {
    $this->story1 = Story::factory()
        ->has(Story::factory()->count(3)->sequence(
            ['order_column' => 1],
            ['order_column' => 2],
            ['order_column' => 3],
        ), 'stories')
        ->create(['order_column' => 1]);

    $this->story2 = Story::factory()
        ->has(Story::factory()->count(3)->sequence(
            ['order_column' => 1],
            ['order_column' => 2],
            ['order_column' => 3],
        ), 'stories')
        ->create(['order_column' => 2]);
});

describe('without story', function () {
    test('can mount', function () {
        livewire(StoryPosition::class)
            ->assertOk()
            ->assertSet('story', null)
            ->assertSet('neighborId', $this->story2->id)
            ->assertSet('neighbor', Story::withCount('stories')->find($this->story2->id))
            ->assertSet('direction', 'after');
    });

    test('can mount for creating a story inside another story', function () {
        livewire(StoryPosition::class, ['parentId' => $this->story1->id])
            ->assertOk()
            ->assertSet('parentId', $this->story1->id)
            ->assertSet('parentStory', Story::withCount('stories')->find($this->story1->id));
    });

    test('can mount for creating a story before another story', function () {
        livewire(StoryPosition::class, ['direction' => 'before', 'neighborId' => $this->story1->id])
            ->assertOk()
            ->assertSet('parentId', null)
            ->assertSet('direction', 'before')
            ->assertSet('neighbor', Story::withCount('stories')->find($this->story1->id));
    });

    test('can mount for creating a story after another story', function () {
        livewire(StoryPosition::class, ['direction' => 'after', 'neighborId' => $this->story1->id])
            ->assertOk()
            ->assertSet('parentId', null)
            ->assertSet('direction', 'after')
            ->assertSet('neighbor', Story::withCount('stories')->find($this->story1->id));
    });
});

describe('with story', function () {
    test('can mount', function () {
        $story = Story::find($this->story1->id);
        $neighbor = Story::find($this->story2->id);

        livewire(StoryPosition::class, ['story' => $story])
            ->assertOk()
            ->assertSet('story', $story)
            ->assertSet('neighborId', $neighbor->id)
            ->assertSet('neighbor', $neighbor)
            ->assertSet('direction', 'before');
    });

    test('can mount for nested story', function () {
        $story = Story::find($this->story1->stories->first()->id);

        livewire(StoryPosition::class, ['story' => $story])
            ->assertOk()
            ->assertSet('story', $story)
            ->assertSet('parentId', $this->story1->id)
            ->assertSet('parentStory', Story::withCount('stories')->find($this->story1->id))
            ->assertSet('direction', 'before');
    });
});

test('stories for ordering change based on the selected parent story', function () {
    livewire(StoryPosition::class)
        ->set('parentId', $this->story1->id)
        ->assertSet('parentStory', Story::withCount('stories')->find($this->story1->id))
        ->assertSet('storiesForOrdering', $this->story1->stories)
        ->set('parentId', $this->story2->id)
        ->assertSet('parentStory', Story::withCount('stories')->find($this->story2->id))
        ->assertSet('storiesForOrdering', $this->story2->stories);
});
