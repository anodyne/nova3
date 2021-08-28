<?php

declare(strict_types=1);

namespace Nova\Notes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Models\Note;
use Nova\Notes\Requests\CreateNoteRequest;
use Nova\Notes\Responses\CreateNoteResponse;

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

    public function store(CreateNoteRequest $request)
    {
        $this->authorize('create', Note::class);

        $note = CreateNote::run(NoteData::fromRequest($request));

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} was created");
    }
}
