<?php

declare(strict_types=1);
use Nova\Stories\Actions\UpdateStoryStatus;
use Nova\Stories\Models\Story;

beforeEach(function () {
    $this->story = Story::factory()->upcoming()->create();
});
it('can update the story status', function () {
    expect($this->story->is_upcoming)->toBeTrue();

    $story = UpdateStoryStatus::run($this->story, 'current');

    expect($story->is_current)->toBeTrue();
});
it('cannot transition to the status its in now', function () {
    $story = UpdateStoryStatus::run($this->story, 'upcoming');

    expect($story->is_upcoming)->toBeTrue();
});
it('can transition from upcoming to current', function () {
    $story = Story::factory()->upcoming()->create();

    $story = UpdateStoryStatus::run($story, 'current');

    expect($story->is_current)->toBeTrue();
    expect($story->started_at)->not->toBeNull();
});
it('can transition from upcoming to completed', function () {
    $story = Story::factory()->upcoming()->create();

    $story = UpdateStoryStatus::run($story, 'completed');

    expect($story->is_completed)->toBeTrue();
    expect($story->started_at)->not->toBeNull();
    expect($story->ended_at)->not->toBeNull();
});
it('can transition from current to upcoming', function () {
    $story = Story::factory()->current()->create([
        'started_at' => now(),
    ]);

    $story = UpdateStoryStatus::run($story, 'upcoming');

    expect($story->is_upcoming)->toBeTrue();
    expect($story->started_at)->toBeNull();
    expect($story->ended_at)->toBeNull();
});
it('can transition from current to completed', function () {
    $story = Story::factory()->current()->create([
        'started_at' => now(),
    ]);

    $story = UpdateStoryStatus::run($story, 'completed');

    expect($story->is_completed)->toBeTrue();
    expect($story->started_at)->not->toBeNull();
    expect($story->ended_at)->not->toBeNull();
});
it('can transition from completed to upcoming', function () {
    $story = Story::factory()->completed()->create([
        'started_at' => now(),
        'ended_at' => now(),
    ]);

    $story = UpdateStoryStatus::run($story, 'upcoming');

    expect($story->is_upcoming)->toBeTrue();
    expect($story->started_at)->toBeNull();
    expect($story->ended_at)->toBeNull();
});
it('can transition from completed to current', function () {
    $story = Story::factory()->completed()->create([
        'started_at' => now(),
        'ended_at' => now(),
    ]);

    $story = UpdateStoryStatus::run($story, 'current');

    expect($story->is_current)->toBeTrue();
    expect($story->started_at)->not->toBeNull();
    expect($story->ended_at)->toBeNull();
});
