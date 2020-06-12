<?php

namespace Nova\Notes\Providers;

use Nova\Notes\Models\Note;
use Nova\DomainServiceProvider;
use Nova\Notes\Policies\NotePolicy;
use Nova\Notes\Http\Responses\ShowNoteResponse;
use Nova\Notes\Http\Responses\CreateNoteResponse;
use Nova\Notes\Http\Responses\UpdateNoteResponse;
use Nova\Notes\Http\Responses\ShowAllNotesResponse;
use Nova\Notes\Http\Controllers\SearchNotesController;
use Nova\Notes\Http\Responses\DeleteNoteResponse;

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

    protected $routes = [
        'notes/search' => [
            'verb' => 'get',
            'uses' => SearchNotesController::class,
            'as' => 'notes.search',
        ],
    ];
}
