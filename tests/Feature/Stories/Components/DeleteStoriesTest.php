<?php

declare(strict_types=1);

use Nova\Stories\Livewire\DeleteStories;
use Nova\Stories\Models\Story;

use function Pest\Livewire\livewire;

uses()->group('stories', 'storytelling', 'components');

test('it initializes default delete actions for every story', function (): void {
    $stories = Story::factory()->count(2)->create();

    livewire(DeleteStories::class, ['stories' => $stories])
        ->assertSet("actions.{$stories[0]->id}.story.action", 'delete')
        ->assertSet("actions.{$stories[0]->id}.posts.action", 'delete')
        ->assertSet("actions.{$stories[1]->id}.story.action", 'delete')
        ->assertSet("actions.{$stories[1]->id}.posts.action", 'delete');
});

test('stories available for moving posts exclude current story and stories marked for deletion', function (): void {
    $storyA = Story::factory()->create();
    $storyB = Story::factory()->create();
    $storyC = Story::factory()->create();

    $storiesToDelete = Story::query()
        ->whereKey([$storyA->id, $storyB->id])
        ->get();

    $component = livewire(DeleteStories::class, ['stories' => $storiesToDelete]);

    $availableForPosts = $component->instance()->getStoriesForMovingPosts($storyA->id);

    expect($availableForPosts->pluck('id')->sort()->values()->all())->toBe([$storyC->id]);
});

test('stories available for moving stories include entries not marked for deletion', function (): void {
    $storyA = Story::factory()->create();
    $storyB = Story::factory()->create();
    $storyC = Story::factory()->create();

    $storiesToDelete = Story::query()
        ->whereKey([$storyA->id, $storyB->id])
        ->get();

    $component = livewire(DeleteStories::class, ['stories' => $storiesToDelete])
        ->set("actions.{$storyB->id}.story.action", 'move');

    $availableForStories = $component->instance()->getStoriesForMovingStories($storyA->id);

    expect($availableForStories->pluck('id')->sort()->values()->all())
        ->toBe(collect([$storyB->id, $storyC->id])->sort()->values()->all());
});
