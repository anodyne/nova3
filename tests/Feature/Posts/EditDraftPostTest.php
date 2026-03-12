<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\get;

uses()->group('posts', 'storytelling');

beforeEach(function () {
    $postType = PostType::factory()->create();

    $this->post = Post::factory()->draft()->create([
        'post_type_id' => $postType->id,
    ]);
});

describe('authorized user', function () {
    test('can edit a draft post with post update permission', function () {
        signIn(permissions: ['post.create', 'post.update']);

        get(route('admin.posts.edit', $this->post))
            ->assertSuccessful()
            ->assertSeeLivewire(PostComposer::class)
            ->assertViewHas(
                'post',
                fn (Post $post): bool => $post->is($this->post)
                    && $post->relationLoaded('participatingUsers')
                    && $post->relationLoaded('postType')
                    && $post->relationLoaded('story')
            );
    });

    test('can edit a draft post when they are a participant', function () {
        $participant = createUser(permissions: 'post.create');

        $this->post->characterAuthors()->detach();
        $this->post->userAuthors()->sync([
            $participant->id => ['user_id' => $participant->id, 'as' => null],
        ]);

        signInAs($participant);

        get(route('admin.posts.edit', $this->post))
            ->assertSuccessful()
            ->assertSeeLivewire(PostComposer::class);
    });
});

describe('unauthorized user', function () {
    test('cannot edit a draft post when they are not a participant and do not have permission', function () {
        $participant = createUser();

        $this->post->characterAuthors()->detach();
        $this->post->userAuthors()->sync([
            $participant->id => ['user_id' => $participant->id, 'as' => null],
        ]);

        signIn();

        get(route('admin.posts.edit', $this->post))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot edit a draft post', function () {
        get(route('admin.posts.edit', $this->post))
            ->assertRedirectToRoute('login');
    });
});
