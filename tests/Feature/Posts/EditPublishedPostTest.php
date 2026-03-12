<?php

declare(strict_types=1);

use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\get;

uses()->group('posts', 'storytelling');

describe('authorized user', function () {
    test('can edit a published post with post update permission', function () {
        $postType = PostType::factory()->create();

        $post = Post::factory()->published()->create([
            'post_type_id' => $postType->id,
        ]);

        signIn(permissions: ['post.create', 'post.update']);

        get(route('admin.posts.edit', $post))
            ->assertSuccessful()
            ->assertSeeLivewire(PostComposer::class);
    });

    test('participant can edit a published post within configured edit timeframe', function () {
        $participant = createUser(permissions: 'post.create');

        $postType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: true,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ]);

        $post = Post::factory()->published()->create([
            'post_type_id' => $postType->id,
            'published_at' => now()->subHours(3),
        ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $participant->id => ['user_id' => $participant->id, 'as' => null],
        ]);

        signInAs($participant);

        get(route('admin.posts.edit', $post))
            ->assertSuccessful()
            ->assertSeeLivewire(PostComposer::class);
    });
});

describe('unauthorized user', function () {
    test('participant cannot edit a published post after the configured timeframe expires', function () {
        $participant = createUser(permissions: 'post.create');

        $postType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: true,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ]);

        $post = Post::factory()->published()->create([
            'post_type_id' => $postType->id,
            'published_at' => now()->subHours(5),
        ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $participant->id => ['user_id' => $participant->id, 'as' => null],
        ]);

        signInAs($participant);

        get(route('admin.posts.edit', $post))->assertForbidden();
    });

    test('participant cannot edit a published post when edit timeframe is never', function () {
        $participant = createUser(permissions: 'post.create');

        $postType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: true,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Never,
            ),
        ]);

        $post = Post::factory()->published()->create([
            'post_type_id' => $postType->id,
        ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $participant->id => ['user_id' => $participant->id, 'as' => null],
        ]);

        signInAs($participant);

        get(route('admin.posts.edit', $post))->assertForbidden();
    });

    test('cannot edit a published post when not a participant and without permission', function () {
        $participant = createUser();
        $nonParticipant = createUser(permissions: 'post.create');

        $postType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: true,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ]);

        $post = Post::factory()->published()->create([
            'post_type_id' => $postType->id,
            'published_at' => now()->subHours(1),
        ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $participant->id => ['user_id' => $participant->id, 'as' => null],
        ]);

        signInAs($nonParticipant);

        get(route('admin.posts.edit', $post))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot edit a published post', function () {
        $post = Post::factory()->published()->create();

        get(route('admin.posts.edit', $post))
            ->assertRedirectToRoute('login');
    });
});
