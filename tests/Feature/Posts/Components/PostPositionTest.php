<?php

declare(strict_types=1);

use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Livewire\PostPosition;
use Nova\Stories\Livewire\PostPositionEditor;
use Nova\Stories\Models\Post;

use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->post = Post::factory()->draft()->create([
        'title' => 'Post title',
        'location' => 'Post location',
        'day' => 'Day 1',
        'time' => '0900 hours',
    ]);
    $this->post->update(['direction' => PositionDirection::After]);

    $this->user = createUser(permissions: 'post.create');

    $this->post->userAuthors()->attach($this->user, ['user_id' => $this->user->id]);
    $this->post->refresh();
});

describe('PostPosition', function () {
    test('mounts', function () {
        livewire(PostPosition::class, ['post' => $this->post])
            ->assertSet('postId', $this->post->id)
            ->assertSet('title', $this->post->title)
            ->assertSet('location', $this->post->location)
            ->assertSet('day', $this->post->day)
            ->assertSet('time', $this->post->time);
    });

    test('can open editor slide over', function () {
        livewire(PostPosition::class, ['post' => $this->post])
            ->call('openForEditing')
            ->assertDispatched('slide-over.open');
    });

    test('can handle post details updates', function () {
        livewire(PostPosition::class, ['post' => $this->post])
            ->dispatch('post-details-updated',
                title: 'Post title',
                location: 'Post location',
                day: 'Day 2',
                time: '1900 hours'
            )
            ->assertSet('title', 'Post title')
            ->assertSet('location', 'Post location')
            ->assertSet('day', 'Day 2')
            ->assertSet('time', '1900 hours');
    });

    test('can handle position updates from PostPositionEditor', function () {
        $neighbor = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPosition::class, ['post' => $this->post])
            ->dispatch(
                'update-post-position',
                neighborId: $neighbor->id,
                direction: PositionDirection::Before
            )
            ->assertSet('neighbor.id', $neighbor->id)
            ->assertSet('direction', PositionDirection::Before)
            ->assertDispatched('post-updated');
    });

    test('shows post details', function () {
        livewire(PostPosition::class, ['post' => $this->post])
            ->assertSeeText($this->post->title)
            ->assertSeeText("{$this->post->location}, {$this->post->day}, {$this->post->time}");
    });

    test('shows placeholders for empty post details', function () {
        $post = Post::factory()->published()->create([
            'title' => null,
            'location' => null,
            'day' => null,
            'time' => null,
        ]);

        livewire(PostPosition::class, ['post' => $post])
            ->assertSeeText('This post');
    });

    test('shows the previous published post', function () {
        $previousPost = Post::factory()->published()->create(['story_id' => $this->post->story_id]);
        $previousPost->moveBefore($this->post);
        $previousPost->save();

        $this->post->refresh();

        livewire(PostPosition::class, ['post' => $this->post])
            ->assertSet('previousPost.id', $previousPost->id)
            ->assertSeeText($previousPost->title);
    });

    test('shows the next published post', function () {
        $nextPost = Post::factory()->published()->create(['story_id' => $this->post->story_id]);
        $nextPost->moveAfter($this->post);
        $nextPost->save();

        $this->post->refresh();

        livewire(PostPosition::class, ['post' => $this->post])
            ->assertSet('nextPost.id', $nextPost->id)
            ->assertSeeText($nextPost->title);
    });
});

describe('PostPositionEditor', function () {
    test('mounts without sibling post IDs', function () {
        livewire(PostPositionEditor::class, [
            'postId' => $this->post->id,
            'previousId' => null,
            'nextId' => null,
        ])
            ->assertSet('postId', $this->post->id)
            ->assertSet('previousPostId', null)
            ->assertSet('nextPostId', null);
    });

    test('mounts with sibling post IDs', function () {
        $previousPost = Post::factory()->published()->create(['story_id' => $this->post->story_id]);
        $previousPost->moveBefore($this->post);
        $previousPost->save();

        $nextPost = Post::factory()->published()->create(['story_id' => $this->post->story_id]);
        $nextPost->moveAfter($this->post);
        $nextPost->save();

        $this->post->refresh();

        livewire(PostPositionEditor::class, [
            'postId' => $this->post->id,
            'previousId' => $previousPost->id,
            'nextId' => $nextPost->id,
        ])
            ->assertSet('postId', $this->post->id)
            ->assertSet('previousPostId', $previousPost->id)
            ->assertSet('nextPostId', $nextPost->id);
    });

    test('can add a neighbor post', function () {
        $post = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPositionEditor::class, [
            'postId' => $this->post->id,
            'previousId' => null,
            'nextId' => null,
        ])
            ->set('search', $post->title)
            ->call('add', postId: $post->id)
            ->assertSet('search', '')
            ->assertSet('neighbor.id', $post->id);
    });

    test('handles setting the post as the first post of the story', function () {
        $post = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPositionEditor::class, [
            'postId' => $this->post->id,
            'previousId' => null,
            'nextId' => null,
        ])
            ->set('neighbor', $post)
            ->set('direction', PositionDirection::Start)
            ->assertSet('direction', PositionDirection::Start)
            ->assertSet('neighbor', null);
    });

    test('handles setting the post as the last post of the story', function () {
        $post = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPositionEditor::class, [
            'postId' => $this->post->id,
            'previousId' => null,
            'nextId' => null,
        ])
            ->set('neighbor', $post)
            ->set('direction', PositionDirection::End)
            ->assertSet('direction', PositionDirection::End)
            ->assertSet('neighbor', null);
    });

    test('sends updated position back to the PostPosition component', function () {
        $neighbor = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPositionEditor::class, [
            'postId' => $this->post->id,
            'previousId' => null,
            'nextId' => null,
        ])
            ->set('neighbor', $neighbor)
            ->set('direction', PositionDirection::Before)
            ->call('save')
            ->assertDispatched('update-post-position');
    });
});
