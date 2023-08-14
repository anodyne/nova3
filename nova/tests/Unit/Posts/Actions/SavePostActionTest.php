<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\SavePost;
use Nova\Posts\Data\PostData;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
it('creates a post', function () {
    $data = PostData::from([
        'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!',
        'postTypeId' => PostType::factory()->create()->id,
        'storyId' => Story::factory()->create()->id,
        'title' => 'Post Title',
    ]);

    $post = SavePost::run($data);

    expect($post->exists)->toBeTrue();

    expect($post->title)->toEqual('Post Title');
    expect($post->content)->toEqual('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!');
});
it('updates a post if one exists', function () {
    $post = Post::factory()->create([
        'title' => 'Post Title',
    ]);

    expect($post->title)->toEqual('Post Title');

    $data = PostData::from([
        'id' => $post->id,
        'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!',
        'postTypeId' => $post->post_type_id,
        'storyId' => $post->story_id,
        'title' => 'New Post Title',
    ]);

    $newPost = SavePost::run($data);

    expect($newPost->title)->toEqual('New Post Title');
    expect($newPost->id)->toEqual($post->id);
});
it('calculates the word count with simple content', function () {
    $data = PostData::from([
        'content' => 'This is my awesome post.',
        'postTypeId' => PostType::first()->id,
        'storyId' => Story::factory()->create()->id,
    ]);

    expect($data->word_count)->toEqual(5);
});
it('calculates the word count with html content', function () {
    $data = PostData::from([
        'content' => 'This <strong>is</strong> my <span class="font-semibold">awesome</span> post.',
        'postTypeId' => PostType::first()->id,
        'storyId' => Story::factory()->create()->id,
    ]);

    expect($data->word_count)->toEqual(5);
});
