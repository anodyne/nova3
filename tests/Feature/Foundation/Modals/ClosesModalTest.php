<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PostAuthorsEditor;
use Nova\Stories\Livewire\PostSummaryEditor;

use function Pest\Livewire\livewire;

uses()->group('foundation', 'modals');

describe('ClosesModal', function () {
    it('dispatches modal-close when a modal closes itself', function () {
        livewire(PostSummaryEditor::class, ['summary' => 'Ea consequat nisi.'])
            ->call('close')
            ->assertDispatched('modal-close');
    });

    it('dispatches the requested events before closing', function () {
        livewire(PostSummaryEditor::class, ['summary' => 'Ea consequat nisi.'])
            ->set('summary', 'Cillum aute ullamco laborum.')
            ->call('save')
            ->assertDispatched('update-post-summary')
            ->assertDispatched('modal-close');
    });

    it('spreads the payload as positional parameters', function () {
        livewire(PostSummaryEditor::class, ['summary' => null])
            ->set('summary', 'Sunt velit exercitation.')
            ->call('save')
            ->assertDispatched(
                'update-post-summary',
                fn (string $event, array $params): bool => $params === ['Sunt velit exercitation.']
            );
    });

    it('spreads a multi-value payload in order', function () {
        livewire(PostAuthorsEditor::class, [
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->call('close', [
            'update-post-authors' => ['first', 'second', 'third'],
        ])->assertDispatched(
            'update-post-authors',
            fn (string $event, array $params): bool => $params === ['first', 'second', 'third']
        )->assertDispatched('modal-close');
    });

    it('does not dispatch stray events when closing without a payload', function () {
        livewire(PostSummaryEditor::class, ['summary' => null])
            ->call('close')
            ->assertDispatched('modal-close')
            ->assertNotDispatched('update-post-summary');
    });
});
