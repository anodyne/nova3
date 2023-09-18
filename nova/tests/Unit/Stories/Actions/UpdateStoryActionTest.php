<?php

declare(strict_types=1);
use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

beforeEach(function () {
    $this->story = Story::factory()->create();
});
it('updates a story', function () {
    $data = StoryData::from([
        'title' => 'Story Title',
        'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
        'ended_at' => '2020-02-01',
        'started_at' => '2020-01-01',
        'summary' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
    ]);

    $story = UpdateStory::run($this->story, $data);

    expect($story->exists)->toBeTrue();

    expect($story->title)->toEqual('Story Title');
    expect($story->description)->toEqual('Lorem ipsum dolor sit amet consectetur, adipisicing elit.');
    expect($story->summary)->toEqual('Lorem ipsum dolor sit amet consectetur, adipisicing elit.');
    expect($story->started_at->format('Y-m-d'))->toEqual('2020-01-01');
    expect($story->ended_at->format('Y-m-d'))->toEqual('2020-02-01');
});
it('can change the parent of a story', function () {
    $firstStory = Story::factory()->withParent($this->story)->create();

    $newParentStory = Story::factory()->create();

    $data = StoryData::from([
        'title' => $this->story->title,
        'parent_id' => $newParentStory->id,
    ]);

    $story = UpdateStory::run($firstStory, $data);

    $firstStory->refresh();

    expect($story->parent_id)->toEqual($newParentStory->id);
});
