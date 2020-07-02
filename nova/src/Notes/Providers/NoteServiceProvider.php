<?php

namespace Nova\Notes\Providers;

use Nova\Notes\Models\Note;
use Nova\DomainServiceProvider;
use Nova\Notes\Policies\NotePolicy;
use Nova\Notes\Responses\ShowNoteResponse;
use Nova\Notes\Responses\CreateNoteResponse;
use Nova\Notes\Responses\DeleteNoteResponse;
use Nova\Notes\Responses\UpdateNoteResponse;
use Nova\Notes\Responses\ShowAllNotesResponse;

class NoteServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Note::class => NotePolicy::class,
    ];

    protected $responsables = [
        CreateNoteResponse::class,
        DeleteNoteResponse::class,
        UpdateNoteResponse::class,
        ShowAllNotesResponse::class,
        ShowNoteResponse::class,
    ];
}
