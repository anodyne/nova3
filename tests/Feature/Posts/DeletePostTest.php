<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Stories\Events\PostDeleted;
use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'post.delete'));

    test('cannot delete a draft post', function () {
        $post = Post::factory()->draft()->create();

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($post));
    });

    test('can delete a published post', function () {
        Event::fake();

        $post = Post::factory()->published()->create();

        livewire(PostsList::class)
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($post))
            ->callAction(TestAction::make(DeleteAction::class)->table($post))
            ->assertCanNotSeeTableRecords([$post])
            ->assertNotified();

        assertSoftDeleted(Post::class, [
            'id' => $post->id,
        ]);

        assertDatabaseMissing(PostAuthor::class, [
            'post_id' => $post->id,
        ]);

        Event::assertDispatched(PostDeleted::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete a draft post', function () {
        $post = Post::factory()->draft()->create();
        $post->userAuthors()->attach(Auth::id());

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($post));
    });

    test('cannot delete a published post', function () {
        $post = Post::factory()->published()->create();
        $post->userAuthors()->attach(Auth::id());

        livewire(PostsList::class)
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($post));
    });
});
