<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\DeletePost;
use Nova\Posts\Models\Post;
beforeEach(function () {
    $this->post = Post::factory()->create();
});
it('deletes a post', function () {
    $post = DeletePost::run($this->post);

    expect($post->exists)->toBeFalse();
});
