<?php

declare(strict_types=1);

use Nova\Foundation\Livewire\ConfirmationModal;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;

use function Pest\Livewire\livewire;

uses()->group('foundation', 'modals');

describe('ConfirmationModal', function () {
    it('falls back to a generic prompt', function () {
        livewire(ConfirmationModal::class, ['callbackComponent' => 'posts-composer'])
            ->assertSet('prompt.title', 'Are you sure?')
            ->assertSet('prompt.message', 'This action cannot be undone.')
            ->assertSet('prompt.confirm', 'Yes, continue')
            ->assertSet('prompt.cancel', 'Cancel')
            ->assertSet('theme', 'warning');
    });

    it('keeps the caller prompt where one is given', function () {
        livewire(ConfirmationModal::class, [
            'callbackComponent' => 'posts-composer',
            'prompt' => [
                'title' => 'Delete post?',
                'confirm' => 'Yes, delete it',
            ],
            'theme' => 'danger',
        ])
            ->assertSet('prompt.title', 'Delete post?')
            ->assertSet('prompt.confirm', 'Yes, delete it')
            ->assertSet('prompt.cancel', 'Cancel')
            ->assertSet('theme', 'danger');
    });

    it('notifies the calling component and closes when confirmed', function () {
        livewire(ConfirmationModal::class, ['callbackComponent' => 'posts-composer'])
            ->call('confirm')
            ->assertHasNoErrors()
            ->assertDispatched('actionConfirmed')
            ->assertDispatched('modal-close');
    });

    it('will not confirm until the phrase matches', function () {
        livewire(ConfirmationModal::class, [
            'callbackComponent' => 'posts-composer',
            'confirmPhrase' => 'DELETE',
        ])
            ->set('confirmPhraseInput', 'delete')
            ->call('confirm')
            ->assertHasErrors('confirmPhraseInput')
            ->assertNotDispatched('actionConfirmed')
            ->assertNotDispatched('modal-close');
    });

    it('confirms once the phrase matches', function () {
        livewire(ConfirmationModal::class, [
            'callbackComponent' => 'posts-composer',
            'confirmPhrase' => 'DELETE',
        ])
            ->set('confirmPhraseInput', 'DELETE')
            ->call('confirm')
            ->assertHasNoErrors()
            ->assertDispatched('actionConfirmed')
            ->assertDispatched('modal-close');
    });

    it('does not require a phrase when none was requested', function () {
        livewire(ConfirmationModal::class, ['callbackComponent' => 'posts-composer'])
            ->assertSet('confirmPhrase', null)
            ->call('confirm')
            ->assertHasNoErrors()
            ->assertDispatched('actionConfirmed');
    });
});

describe('InteractsWithConfirmationModal', function () {
    beforeEach(function () {
        $this->user = createUser(permissions: ['post.create', 'post.delete']);

        $this->post = Post::factory()
            ->published()
            ->withStory(Story::factory()->current()->create())
            ->create([
                'post_type_id' => PostType::factory()->create()->id,
                'day' => 'Day 1',
                'time' => '0800 hours',
            ]);
        $this->post->characterAuthors()->detach();
        $this->post->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
        ]);
        $this->post->refresh();

        signInAs($this->user);
    });

    it('opens the confirmation modal with the calling component as the callback', function () {
        livewire(PostComposer::class, ['post' => $this->post])
            ->call('delete')
            ->assertDispatched('modal-open', function (string $event, array $params): bool {
                return $params['modal'] === ConfirmationModal::class
                    && $params['props']['callbackComponent'] === 'posts-composer'
                    && $params['props']['theme'] === 'danger';
            });
    });

    it('passes the caller prompt through to the modal', function () {
        livewire(PostComposer::class, ['post' => $this->post])
            ->call('delete')
            ->assertDispatched('modal-open', function (string $event, array $params): bool {
                return $params['props']['prompt']['title'] === 'Delete post?';
            });
    });

    it('records the calling method so it can be replayed', function () {
        livewire(PostComposer::class, ['post' => $this->post])
            ->call('delete')
            ->assertSet('confirmationCaller', 'delete')
            ->assertSet('actionConfirmed', false);
    });

    it('does not run the action until confirmation arrives', function () {
        livewire(PostComposer::class, ['post' => $this->post])
            ->call('delete')
            ->assertNoRedirect();

        expect($this->post->fresh()->trashed())->toBeFalse();
    });

    it('replays the caller once confirmation arrives', function () {
        livewire(PostComposer::class, ['post' => $this->post])
            ->call('delete')
            ->dispatch('actionConfirmed')
            ->assertRedirect(route('admin.writing-overview'));

        expect($this->post->fresh()->trashed())->toBeTrue();
    });

    it('ignores a confirmation that arrives without a recorded caller', function () {
        livewire(PostComposer::class, ['post' => $this->post])
            ->dispatch('actionConfirmed')
            ->assertNoRedirect();

        expect($this->post->fresh()->trashed())->toBeFalse();
    });
});
