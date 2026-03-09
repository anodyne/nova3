<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Nova\Stories\Events\PostDeleted;
use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'post.delete'));

    test('can discard a draft post', function () {
        Event::fake();

        $post = Post::factory()->draft()->create();

        livewire(PostsList::class)
            ->assertActionVisible(TestAction::make('discard')->table($post))
            ->callAction(TestAction::make('discard')->table($post))
            ->assertCanNotSeeTableRecords([$post])
            ->assertNotified();

        assertDatabaseMissing(Post::class, [
            'id' => $post->id,
        ]);

        assertDatabaseMissing(PostAuthor::class, [
            'post_id' => $post->id,
        ]);

        Event::assertDispatched(PostDeleted::class);
    });

    test('cannot discard a published post', function () {
        $post = Post::factory()->published()->create();

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make('discard')->table($post));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('can discard a draft post they are part of', function () {
        $post = Post::factory()->draft()->create();
        $post->userAuthors()->attach(Auth::id());

        livewire(PostsList::class)
            ->assertActionVisible(TestAction::make('discard')->table($post));
    });

    test('cannot discard a draft post they are not part of', function () {
        $post = Post::factory()->draft()->create();
        PostAuthor::where('post_id', $post->id)->where('user_id', Auth::id())->delete();

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make('discard')->table($post));
    });

    test('cannot discard any published post', function () {
        $linkedPublishedPost = Post::factory()->published()->create();
        $linkedPublishedPost->userAuthors()->attach(Auth::id());

        $unlinkedPublishedPost = Post::factory()->published()->create();

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make('discard')->table($linkedPublishedPost))
            ->assertActionHidden(TestAction::make('discard')->table($unlinkedPublishedPost));
    });
});
