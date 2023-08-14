<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Models\Post;
use Nova\Stories\Actions\DeleteStoryPosts;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->story = Story::factory()->create();

    $this->posts = Post::factory()->count(5)->create([
        'story_id' => $this->story,
    ]);

    $this->story->refresh();
});
it('deletes the posts in a story', function () {
    expect($this->story->posts)->toHaveCount(5);

    $story = DeleteStoryPosts::run($this->story);

    expect($story->posts)->toHaveCount(0);
});
