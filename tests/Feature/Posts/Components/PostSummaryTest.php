<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Livewire\PostSummary;
use Nova\Stories\Livewire\PostSummaryEditor;
use Nova\Stories\Models\Post;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->post = Post::factory()->draft()->create();
});

describe('PostSummary', function () {
    test('mounts', function () {
        livewire(PostSummary::class, ['post' => $this->post])
            ->assertSet('postId', $this->post->id)
            ->assertSet('summary', $this->post->summary);
    });

    test('can open editor slide over', function () {
        livewire(PostSummary::class, ['post' => $this->post])
            ->call('openForEditing')
            ->assertDispatched('modal-open');
    });

    test('can save summary', function () {
        livewire(PostSummary::class, ['post' => $this->post])
            ->set('summary', 'Laboris sint adipisicing excepteur aliquip voluptate sunt.')
            ->dispatch('save-post')
            ->assertDispatchedTo(PostComposer::class, 'save-post-completed');

        assertDatabaseHas(Post::class, [
            'id' => $this->post->id,
            'summary' => 'Laboris sint adipisicing excepteur aliquip voluptate sunt.',
        ]);
    });

    test('can handle summary updates from PostSummaryEditor', function () {
        livewire(PostSummary::class, ['post' => $this->post])
            ->dispatch(
                'update-post-summary',
                summary: 'Deserunt incididunt dolore aliqua laborum mollit.'
            )
            ->assertSet('summary', 'Deserunt incididunt dolore aliqua laborum mollit.')
            ->assertDispatched('post-updated');
    });
});

describe('PostSummaryEditor', function () {
    test('mounts', function () {
        livewire(PostSummaryEditor::class, ['summary' => $this->post->summary])
            ->assertSet('summary', $this->post->summary);
    });

    test('sets the summary', function () {
        livewire(PostSummaryEditor::class, ['summary' => $this->post->summary])
            ->set('summary', 'Est cillum reprehenderit dolor consectetur nulla ex.')
            ->assertSet('summary', 'Est cillum reprehenderit dolor consectetur nulla ex.');
    });

    test('sends updated summary back to the PostSummary component', function () {
        livewire(PostSummaryEditor::class, ['summary' => $this->post->summary])
            ->set('summary', 'Ad dolor minim sunt.')
            ->call('save')
            ->assertDispatched('update-post-summary');
    });
});
