<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\PostTypes\Models\PostType;
beforeEach(function () {
    $this->postType = PostType::factory()->create();
});
it('deletes a post type', function () {
    $postType = DeletePostType::run($this->postType);

    expect($postType->deleted_at)->not->toBeNull();
});
