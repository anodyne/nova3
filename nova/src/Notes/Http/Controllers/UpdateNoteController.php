<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Http\Requests\UpdateNoteRequest;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Notes\Http\Responses\UpdateNoteResponse;

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

    public function update(
        UpdateNoteRequest $request,
        Note $note,
        UpdateNote $action
    ) {
        $this->authorize('update', $note);

        $note = $action->execute($note, NoteData::fromRequest($request));

        return back()->withToast("{$note->title} was updated");
    }
}
