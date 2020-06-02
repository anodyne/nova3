<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DeleteNote;
use Nova\Foundation\Http\Controllers\Controller;

class DeleteNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Note $note, DeleteNote $action)
    {
        $this->authorize('delete', $note);

        $action->execute($note);

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} was deleted.");
    }
}
