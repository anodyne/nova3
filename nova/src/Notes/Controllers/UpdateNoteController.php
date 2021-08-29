<?php

declare(strict_types=1);

namespace Nova\Notes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Models\Note;
use Nova\Notes\Requests\UpdateNoteRequest;
use Nova\Notes\Responses\UpdateNoteResponse;

class UpdateNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);

        return app(UpdateNoteResponse::class)->with([
            'note' => $note,
        ]);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $note = UpdateNote::run($note, NoteData::fromRequest($request));

        return back()->withToast("{$note->title} was updated");
    }
}
