<?php

declare(strict_types=1);
use Nova\Stories\Actions\DeleteStory;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->story = Story::factory()->create();
});
it('deletes a story', function () {
    $story = DeleteStory::run($this->story);

    expect($story->exists)->toBeFalse();
});
