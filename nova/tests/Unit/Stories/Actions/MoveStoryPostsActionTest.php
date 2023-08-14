<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Models\Post;
use Nova\Stories\Actions\MoveStoryPosts;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->newStory = Story::factory()->create();

    $this->story = Story::factory()->create();

    Post::factory()->count(5)->create([
        'story_id' => $this->story,
    ]);

    $this->story->refresh();
});
it('moves posts to another story', function () {
    expect($this->story->posts)->toHaveCount(5);

    $story = MoveStoryPosts::run($this->story, $this->newStory);

    $this->story->refresh();

    expect($this->story->posts)->toHaveCount(0);
    expect($story->posts)->toHaveCount(5);
});
