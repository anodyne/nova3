<?php

declare(strict_types=1);
use Nova\Posts\Actions\UpdatePostStatus;
use Nova\Posts\Data\PostStatusData;
use Nova\Posts\Models\Post;

beforeEach(function () {
    $this->post = Post::factory()->draft()->create();
});
it('can update the post status', function () {
    expect($this->post->is_draft)->toBeTrue();

    $post = UpdatePostStatus::run($this->post, PostStatusData::from([
        'status' => 'published',
    ]));

    expect($post->is_published)->toBeTrue();
});
it('cannot transition to the status its in now', function () {
    $post = UpdatePostStatus::run($this->post, PostStatusData::from([
        'status' => 'draft',
    ]));

    expect($post->is_draft)->toBeTrue();
});
it('can transition from draft to published', function () {
    $post = Post::factory()->draft()->create();

    $post = UpdatePostStatus::run($post, PostStatusData::from([
        'status' => 'published',
    ]));

    expect($post->is_published)->toBeTrue();
    expect($post->published_at)->not->toBeNull();
});
it('can transition from draft to pending', function () {
    $post = Post::factory()->draft()->create();

    $post = UpdatePostStatus::run($post, PostStatusData::from([
        'status' => 'pending',
    ]));

    expect($post->is_pending)->toBeTrue();
    expect($post->published_at)->toBeNull();
});
it('can transition from pending to published', function () {
    $post = Post::factory()->pending()->create();

    $post = UpdatePostStatus::run($post, PostStatusData::from([
        'status' => 'published',
    ]));

    expect($post->is_published)->toBeTrue();
    expect($post->published_at)->not->toBeNull();
});
