<?php

namespace Nova\Notes\Providers;

use Nova\Notes\Models\Note;
use Nova\DomainServiceProvider;
use Nova\Notes\Policies\NotePolicy;
use Nova\Notes\Http\Responses\EditNoteResponse;
use Nova\Notes\Http\Responses\NoteIndexResponse;
use Nova\Notes\Http\Responses\CreateNoteResponse;
use Nova\Notes\Http\Controllers\SearchNotesController;

class NoteServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Note::class => NotePolicy::class,
    ];

    protected $responsables = [
        CreateNoteResponse::class,
        EditNoteResponse::class,
        NoteIndexResponse::class,
    ];

    protected $routes = [
        'notes/search' => [
            'verb' => 'get',
            'uses' => SearchNotesController::class,
            'as' => 'notes.search',
        ],
    ];
}
