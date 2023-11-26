<?php

declare(strict_types=1);
use Nova\Stories\Actions\DuplicatePostType;
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType = PostType::factory()->create([
        'sort' => 0,
        'role_id' => 1,
    ]);
});
it('duplicates a post type', function () {
    $postType = DuplicatePostType::run($this->postType);

    expect($postType->name)->toEqual("Copy of {$this->postType->name}");
    expect($postType->sort)->toEqual(PostType::count() - 1);
    expect($postType->role_id)->toEqual(1);
});
