<?php

declare(strict_types=1);
use Nova\Stories\Actions\SetStoryPosition;
use Nova\Stories\Data\StoryPositionData;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->story = Story::factory()->create();
});
it('moves a story before another story', function () {
    expect($this->story->order_column)->toEqual(1);

    $newFirstStory = Story::factory()->create();

    $data = StoryPositionData::from([
        'direction' => 'before',
        'neighbor' => $this->story,
        'hasPositionChange' => true,
    ]);

    SetStoryPosition::run($newFirstStory, $data);

    $this->story->refresh();
    $newFirstStory->refresh();

    expect($newFirstStory->order_column)->toEqual(1);
    expect($this->story->order_column)->toEqual(2);
});
it('moves a story after another story', function () {
    $secondStory = Story::factory()->create();

    $secondStory->refresh();

    expect($this->story->order_column)->toEqual(1);
    expect($secondStory->order_column)->toEqual(2);

    $newSecondStory = Story::factory()->create();

    $data = StoryPositionData::from([
        'direction' => 'after',
        'neighbor' => $this->story,
        'hasPositionChange' => true,
    ]);

    SetStoryPosition::run($newSecondStory, $data);

    $this->story->refresh();
    $newSecondStory->refresh();
    $secondStory->refresh();

    expect($this->story->order_column)->toEqual(1);
    expect($newSecondStory->order_column)->toEqual(2);
    expect($secondStory->order_column)->toEqual(3);
});
it('moves a nested story before another story with the same parent', function () {
    $secondRootStory = Story::factory()->create();

    $firstStory = Story::factory()->withParent($this->story)->create();

    $secondStory = Story::factory()->withParent($this->story)->create();

    $firstStory->refresh();
    $secondStory->refresh();

    $data = StoryPositionData::from([
        'direction' => 'before',
        'neighbor' => $firstStory,
        'hasPositionChange' => true,
    ]);

    SetStoryPosition::run($secondStory, $data);

    $this->story->refresh();
    $secondRootStory->refresh();
    $firstStory->refresh();
    $secondStory->refresh();

    expect($this->story->order_column)->toEqual(1);
    expect($secondRootStory->order_column)->toEqual(2);
    expect($secondStory->order_column)->toEqual(1);
    expect($firstStory->order_column)->toEqual(2);
});
it('moves a nested story after another story with the same parent', function () {
    $secondRootStory = Story::factory()->create();

    $firstStory = Story::factory()->withParent($this->story)->create();

    $secondStory = Story::factory()->withParent($this->story)->create();

    $thirdStory = Story::factory()->withParent($this->story)->create();

    $firstStory->refresh();
    $secondStory->refresh();
    $thirdStory->refresh();

    $data = StoryPositionData::from([
        'direction' => 'after',
        'neighbor' => $firstStory,
        'hasPositionChange' => true,
    ]);

    SetStoryPosition::run($thirdStory, $data);

    $this->story->refresh();
    $secondRootStory->refresh();
    $firstStory->refresh();
    $secondStory->refresh();
    $thirdStory->refresh();

    expect($this->story->order_column)->toEqual(1);
    expect($secondRootStory->order_column)->toEqual(2);
    expect($firstStory->order_column)->toEqual(1);
    expect($thirdStory->order_column)->toEqual(2);
    expect($secondStory->order_column)->toEqual(3);
});
