<?php

declare(strict_types=1);

namespace Nova\Notes\Providers;

use Nova\DomainServiceProvider;
use Nova\Notes\Models\Note;
use Nova\Notes\Policies\NotePolicy;

class NotesServiceProvider extends DomainServiceProvider
{
    public function policies(): array
    {
        return [
            Note::class => NotePolicy::class,
        ];
    }
}
