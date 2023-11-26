<?php

declare(strict_types=1);
use Nova\Stories\Actions\DeletePost;
use Nova\Stories\Models\Post;

beforeEach(function () {
    $this->post = Post::factory()->create();
});
it('deletes a post', function () {
    $post = DeletePost::run($this->post);

    expect($post->exists)->toBeFalse();
});
