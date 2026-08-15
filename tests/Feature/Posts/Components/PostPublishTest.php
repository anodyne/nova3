<?php

declare(strict_types=1);

use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Livewire\PostPublish;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->post = Post::factory()->draft()->create([
        'title' => 'Post title',
        'location' => 'Post location',
        'day' => 'Day 1',
        'time' => '0900 hours',
        'content' => '',
    ]);

    $this->user = createUser(permissions: 'post.create');

    $this->post->userAuthors()->attach($this->user, ['user_id' => $this->user->id]);
    $this->post->refresh();
});

it('mounts', function () {
    livewire(PostPublish::class, ['postId' => $this->post->id])
        ->assertSet('postId', $this->post->id)
        ->assertSet('postTypeId', $this->post->post_type_id);
});

it('can dismiss the publish slide over', function () {
    livewire(PostPublish::class, ['postId' => $this->post->id])
        ->call('dismiss')
        ->assertNotified()
        ->assertDispatched('modal-close');
});

it('can publish a post', function () {
    signInAs($this->user);

    livewire(PostPublish::class, ['postId' => $this->post->id])
        ->call('publish')
        ->assertNotified();

    $this->post->refresh();

    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'status' => 'published',
        'locked_at' => null,
        'locked_by' => null,
    ]);
});

describe('post participants', function () {
    test('mounts with participating users', function () {
        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->assertCount('participatingUsers', $this->post->participatingUsers()->count());
    });

    test('shows participants panel when there are more than 1 authors', function () {
        signInAs($this->user);

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->assertSet('shouldShowParticipantsPanel', true)
            ->assertDontSeeText('No participants to review');
    });

    test('hides participants panel when there is only 1 author', function () {
        signIn();

        $currentUser = Auth::user();

        $post = Post::factory()->draft()->create();
        $post->characterAuthors()->detach();
        $post->userAuthors()->detach();
        $post->userAuthors()->attach($currentUser, ['user_id' => $currentUser->id]);
        $post->refresh();

        livewire(PostPublish::class, ['postId' => $post->id])
            ->assertSet('shouldShowParticipantsPanel', false)
            ->assertSeeText('No participants to review');
    });

    test('can determine if there are non-participants on the post', function () {
        PostAuthor::wherePost($this->post)->delete();

        $user1 = User::factory()->active()->create();
        $user2 = User::factory()->active()->create();
        $user3 = User::factory()->active()->create();

        $this->post->userAuthors()->attach($user1, ['user_id' => $user1->id, 'word_count' => 10]);
        $this->post->addParticipant($user1);

        $this->post->userAuthors()->attach($user2, ['user_id' => $user2->id, 'word_count' => 20]);
        $this->post->addParticipant($user2);

        $this->post->userAuthors()->attach($user3, ['user_id' => $user3->id]);

        $this->post->refresh();

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->assertSet('hasNonParticipants', true);
    });

    test('can remove a single participant from the post', function () {
        PostAuthor::wherePost($this->post)->delete();

        $user1 = User::factory()->active()->create();
        $user2 = User::factory()->active()->create();
        $user3 = User::factory()->active()->create();

        $this->post->userAuthors()->attach($user1, ['user_id' => $user1->id, 'word_count' => 10]);
        $this->post->addParticipant($user1);

        $this->post->userAuthors()->attach($user2, ['user_id' => $user2->id, 'word_count' => 20]);
        $this->post->addParticipant($user2);

        $this->post->userAuthors()->attach($user3, ['user_id' => $user3->id]);

        $this->post->refresh();

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->assertSet('hasNonParticipants', true)
            ->call('removeParticipant', userId: $user3->id);

        assertDatabaseHas(PostAuthor::class, [
            'post_id' => $this->post->id,
            'user_id' => $user1->id,
        ]);

        assertDatabaseHas(PostAuthor::class, [
            'post_id' => $this->post->id,
            'user_id' => $user2->id,
        ]);

        assertDatabaseMissing(PostAuthor::class, [
            'post_id' => $this->post->id,
            'user_id' => $user3->id,
        ]);
    });

    test('can remove all non-participants from the post', function () {
        PostAuthor::wherePost($this->post)->delete();

        $user1 = User::factory()->active()->create();
        $user2 = User::factory()->active()->create();
        $user3 = User::factory()->active()->create();

        $this->post->userAuthors()->attach($user1, ['user_id' => $user1->id, 'word_count' => 10]);
        $this->post->addParticipant($user1);

        $this->post->userAuthors()->attach($user2, ['user_id' => $user2->id]);

        $this->post->userAuthors()->attach($user3, ['user_id' => $user3->id]);

        $this->post->refresh();

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->assertSet('hasNonParticipants', true)
            ->call('removeAllNonParticipants');

        $this->post->refresh();

        assertDatabaseHas(PostAuthor::class, [
            'post_id' => $this->post->id,
            'user_id' => $user1->id,
        ]);

        assertDatabaseMissing(PostAuthor::class, [
            'post_id' => $this->post->id,
            'user_id' => $user2->id,
        ]);

        assertDatabaseMissing(PostAuthor::class, [
            'post_id' => $this->post->id,
            'user_id' => $user3->id,
        ]);
    });
});

describe('post position', function () {
    test('mounts with position data', function () {
        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->assertSet('direction', PositionDirection::After);
    });

    test('shows post position panel when there are more than 1 published posts', function () {
        signIn();

        $story = Story::factory()->current()->create();

        Post::factory()->published()->create(['story_id' => $story->id]);

        $post = Post::factory()->draft()->create([
            'story_id' => $story->id,
        ]);

        $story->refresh();

        livewire(PostPublish::class, ['postId' => $post->id])
            ->assertSet('shouldShowPositionPanel', true)
            ->assertDontSeeText('This is the first post in the story');
    });

    test('hides post position panel when there are fewer than 1 published posts', function () {
        signIn();

        $story = Story::factory()->current()->create();
        $post = Post::factory()->draft()->create([
            'story_id' => $story->id,
        ]);

        livewire(PostPublish::class, ['postId' => $post->id])
            ->assertSet('shouldShowPositionPanel', false)
            ->assertSeeText('This is the first post in the story');
    });

    test('can add a neighbor post', function () {
        $post = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->set('search', $post->title)
            ->call('add', postId: $post->id)
            ->assertSet('search', '')
            ->assertSet('neighbor.id', $post->id);
    });

    test('handles setting the post as the first post of the story', function () {
        $post = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->set('neighbor', $post)
            ->set('direction', PositionDirection::Start)
            ->assertSet('direction', PositionDirection::Start)
            ->assertSet('neighbor', null);
    });

    test('handles setting the post as the last post of the story', function () {
        $post = Post::factory()->published()->create(['story_id' => $this->post->story_id]);

        livewire(PostPublish::class, ['postId' => $this->post->id])
            ->set('neighbor', $post)
            ->set('direction', PositionDirection::End)
            ->assertSet('direction', PositionDirection::End)
            ->assertSet('neighbor', null);
    });

    describe('save post position', function () {
        beforeEach(function () {
            $this->story = Story::factory()->create();

            $this->draftPost = Post::factory()->draft()->create(['story_id' => $this->story->id]);
            $this->publishedPost = Post::factory()->published()->create(['story_id' => $this->story->id]);
        });

        test('before another post', function () {
            livewire(PostPublish::class, ['postId' => $this->draftPost->id])
                ->set('neighbor', $this->publishedPost)
                ->set('direction', PositionDirection::Before)
                ->call('updatePostPosition');

            $this->draftPost->refresh();
            $this->publishedPost->refresh();

            expect($this->draftPost->order_column)->toBeLessThan($this->publishedPost->order_column);
        });

        test('after another post', function () {
            livewire(PostPublish::class, ['postId' => $this->draftPost->id])
                ->set('neighbor', $this->publishedPost)
                ->set('direction', PositionDirection::After)
                ->call('updatePostPosition');

            $this->draftPost->refresh();
            $this->publishedPost->refresh();

            expect($this->draftPost->order_column)->toBeGreaterThan($this->publishedPost->order_column);
        });

        test('first post of the story', function () {
            livewire(PostPublish::class, ['postId' => $this->draftPost->id])
                ->set('direction', PositionDirection::Start)
                ->call('updatePostPosition');

            $this->draftPost->refresh();

            expect($this->draftPost->order_column)->toBe(1);
        });

        test('last post of the story', function () {
            livewire(PostPublish::class, ['postId' => $this->draftPost->id])
                ->set('direction', PositionDirection::End)
                ->call('updatePostPosition');

            $this->draftPost->refresh();

            expect($this->draftPost->order_column)->toBe($this->story->allPosts()->count());
        });
    });
});
