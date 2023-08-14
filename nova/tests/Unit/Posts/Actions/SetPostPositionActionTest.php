<?php

declare(strict_types=1);
use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->story = Story::factory()->create();
});
it('can add a post to the end of the story', function () {
    $post = Post::factory()->count(5)->withStory($this->story)->create();

    $post = SetPostPosition::run($post, PostPositionData::from([
        'hasPositionChange' => false,
    ]));

    expect($post->story_id)->toEqual($this->story->id);
    expect($post->order_column)->toEqual(1);
});
it('can add a post before the first post', function () {
    $posts = Post::factory()->count(2)->withStory($this->story)->create();

    SetPostPosition::run(
        $posts[1],
        PostPositionData::from([
            'hasPositionChange' => true,
            'displayDirection' => 'before',
            'displayNeighbor' => $posts[0]->id,
        ])
    );

    $posts->each->refresh();

    expect($posts[0]->order_column)->toEqual(1);
    expect($posts[1]->order_column)->toEqual(0);
});
it('can add a post after the first post', function () {
    $posts = Post::factory()
        ->count(2)
        ->withStory($this->story)
        ->create();

    $post = SetPostPosition::run(
        $posts[1],
        PostPositionData::from([
            'hasPositionChange' => true,
            'displayDirection' => 'after',
            'displayNeighbor' => $posts[0]->id,
        ])
    );

    $posts->each->refresh();

    expect($posts[0]->nextSibling()->is($posts[1]))->toBeTrue();
    expect($posts[1]->previousSibling()->is($posts[0]))->toBeTrue();
});
it('can move a post before another post', function () {
    $posts = Post::factory()
        ->count(3)
        ->withStory($this->story)
        ->create();

    $posts->each->refresh();

    $post = SetPostPosition::run(
        $posts[2],
        PostPositionData::from([
            'hasPositionChange' => true,
            'displayDirection' => 'before',
            'displayNeighbor' => $posts[1]->id,
        ])
    );

    $posts->each->refresh();

    expect($posts[0]->nextSibling()->is($posts[2]))->toBeTrue();
    expect($posts[1]->previousSibling()->is($posts[2]))->toBeTrue();
    expect($posts[2]->previousSibling()->is($posts[0]))->toBeTrue();
    expect($posts[2]->nextSibling()->is($posts[1]))->toBeTrue();
});
it('can move a post after another post', function () {
    $posts = Post::factory()
        ->count(3)
        ->withStory($this->story)
        ->create();

    $posts->each->refresh();

    $post = SetPostPosition::run(
        $posts[2],
        PostPositionData::from([
            'hasPositionChange' => true,
            'displayDirection' => 'after',
            'displayNeighbor' => $posts[0]->id,
        ])
    );

    $posts->each->refresh();

    expect($posts[0]->nextSibling()->is($posts[2]))->toBeTrue();
    expect($posts[1]->previousSibling()->is($posts[2]))->toBeTrue();
    expect($posts[2]->previousSibling()->is($posts[0]))->toBeTrue();
    expect($posts[2]->nextSibling()->is($posts[1]))->toBeTrue();
});
