<?php

declare(strict_types=1);

namespace Nova\Notes\Providers;

use Nova\DomainServiceProvider;
use Nova\Notes\Livewire\NotesList;
use Nova\Notes\Models\Note;
use Nova\Notes\Spotlight\AddNote;
use Nova\Notes\Spotlight\EditNote;
use Nova\Notes\Spotlight\ViewNote;
use Nova\Notes\Spotlight\ViewNotes;

class NotesServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'notes-list' => NotesList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'note' => Note::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddNote::class,
            EditNote::class,
            ViewNote::class,
            ViewNotes::class,
        ];
    }
}
