<?php

declare(strict_types=1);

namespace Nova\Notes\Providers;

use Nova\DomainServiceProvider;
use Nova\Notes\Spotlight\AddNote;
use Nova\Notes\Spotlight\EditNote;
use Nova\Notes\Spotlight\ViewNote;
use Nova\Notes\Spotlight\ViewNotes;

class NotesServiceProvider extends DomainServiceProvider
{
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
