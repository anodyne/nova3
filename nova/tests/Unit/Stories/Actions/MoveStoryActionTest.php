<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Stories\Actions\MoveStory;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->newStory = Story::factory()->create();

    $this->story = Story::factory()->create();

    $this->story->refresh();
    $this->newStory->refresh();
});
it('moves a story', function () {
    $story = MoveStory::run($this->story, $this->newStory);

    expect($story->parent_id)->toEqual($this->newStory->id);
});
