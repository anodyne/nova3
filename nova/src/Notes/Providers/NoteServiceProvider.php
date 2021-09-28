<?php

declare(strict_types=1);

namespace Nova\Notes\Providers;

use Nova\DomainServiceProvider;
use Nova\Notes\Models\Note;
use Nova\Notes\Policies\NotePolicy;
use Nova\Notes\Responses\CreateNoteResponse;
use Nova\Notes\Responses\DeleteNoteResponse;
use Nova\Notes\Responses\ShowAllNotesResponse;
use Nova\Notes\Responses\ShowNoteResponse;
use Nova\Notes\Responses\UpdateNoteResponse;

class NoteServiceProvider extends DomainServiceProvider
{
    public function policies(): array
    {
        return [
            Note::class => NotePolicy::class,
        ];
    }

    public function responsables(): array
    {
        return [
            CreateNoteResponse::class,
            DeleteNoteResponse::class,
            ShowAllNotesResponse::class,
            ShowNoteResponse::class,
            UpdateNoteResponse::class,
        ];
    }
}
