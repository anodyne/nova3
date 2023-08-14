<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\MovePost;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->story = Story::factory()->create();

    $this->post = Post::factory()->create();
});
it('moves a post', function () {
    $post = MovePost::run($this->post, $this->story);

    expect($post->story_id)->toEqual($this->story->id);
});
