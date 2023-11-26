<?php

declare(strict_types=1);
use Nova\Stories\Actions\DeletePostType;
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});
it('deletes a post type', function () {
    $postType = DeletePostType::run($this->postType);

    expect($postType->deleted_at)->not->toBeNull();
});
