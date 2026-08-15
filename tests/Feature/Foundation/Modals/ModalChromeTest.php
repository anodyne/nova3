<?php

declare(strict_types=1);

use Nova\Media\Livewire\AvatarEditor;
use Nova\Search\Livewire\GlobalSearch;
use Nova\Stories\Livewire\PostAuthorsEditor;
use Nova\Stories\Livewire\PostSummaryEditor;

use function Pest\Livewire\livewire;

uses()->group('foundation', 'modals');

describe('modal chrome', function () {
    it('renders a modal inside the overlay stack', function () {
        livewire(AvatarEditor::class)
            ->assertOk()
            ->assertSeeHtml('x-bind="modalAttributes"');
    });

    it('renders a slide over inside the overlay stack', function () {
        livewire(PostSummaryEditor::class, ['summary' => null])
            ->assertOk()
            ->assertSeeHtml('x-bind="modalAttributes"');
    });

    it('renders a chrome-less modal inside the overlay stack', function () {
        livewire(GlobalSearch::class)
            ->assertOk()
            ->assertSeeHtml('x-bind="modalAttributes"');
    });

    it('opens global search without a search term', function () {
        // The search driver rejects a null phrase, so an unsearched modal must
        // not reach the engine at all.
        livewire(GlobalSearch::class)
            ->assertOk()
            ->assertSet('search', null)
            ->assertViewHas('numberOfResults', 0);
    });

    it('applies the declared size to the overlay', function () {
        livewire(PostAuthorsEditor::class, ['characterAuthors' => [], 'userAuthors' => []])
            ->assertOk()
            ->assertSeeHtml('max-w-3xl');
    });

    it('applies the default size when none is declared', function () {
        livewire(AvatarEditor::class)
            ->assertOk()
            ->assertSeeHtml('max-w-lg');
    });

    it('renders a slide over full height so it spans the trailing edge', function () {
        livewire(PostSummaryEditor::class, ['summary' => null])
            ->assertOk()
            ->assertSeeHtml('h-full');
    });

    it('renders a close control wired to the overlay', function () {
        livewire(AvatarEditor::class)
            ->assertOk()
            ->assertSeeHtml('x-modal:close');
    });
});
