<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Stories\Models\Story;
it('creates a root post', function () {
    $post = CreateRootPost::run($story = Story::factory()->create());

    expect($post->exists)->toBeTrue();

    expect($post->title)->toEqual("{$story->title} Root Post");
    expect($post->story_id)->toEqual($story->id);
    expect($post->parent_id)->toBeNull();
});
