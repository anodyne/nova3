<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Http\Requests\CreateNoteRequest;
use Nova\Foundation\Http\Controllers\Controller;

class CreateNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Note::class);

        return app(CreateNoteResponse::class);
    }

    public function store(CreateNoteRequest $request, CreateNote $action)
    {
        $this->authorize('create', Note::class);

        $note = $action->execute(NoteData::fromRequest($request));

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} note was created");
    }
}
