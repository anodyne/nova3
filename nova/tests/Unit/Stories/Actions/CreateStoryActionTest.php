<?php

declare(strict_types=1);
use Nova\Stories\Actions\CreateStory;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

it('creates a story', function () {
    $data = StoryData::from([
        'title' => 'Story Title',
        'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
        'ended_at' => '2020-02-01',
        'started_at' => '2020-01-01',
        'summary' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
    ]);

    $story = CreateStory::run($data);

    expect($story->exists)->toBeTrue();

    expect($story->title)->toEqual('Story Title');
    expect($story->description)->toEqual('Lorem ipsum dolor sit amet consectetur, adipisicing elit.');
    expect($story->summary)->toEqual('Lorem ipsum dolor sit amet consectetur, adipisicing elit.');
    expect($story->parent_id)->toBeNull();
    expect($story->started_at->format('Y-m-d'))->toEqual('2020-01-01');
    expect($story->ended_at->format('Y-m-d'))->toEqual('2020-02-01');
});
it('creates a nested story', function () {
    $newStory = Story::factory()->create();

    $data = StoryData::from([
        'title' => 'Story Title',
        'parent_id' => $newStory->id,
    ]);

    $story = CreateStory::run($data);

    expect($story->parent_id)->toEqual($newStory->id);
});
