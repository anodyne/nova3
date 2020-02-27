<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Notes\Http\Requests\ValidateDuplicateNote;

class DuplicateNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(
        ValidateDuplicateNote $request,
        DuplicateNote $action,
        Note $originalNote
    ) {
        $this->authorize('duplicate', $originalNote);

        $note = $action->execute($originalNote);

        event(new NoteDuplicated($note, $originalNote));

        return redirect()
            ->route('notes.edit', $note)
            ->withToast("{$originalNote->title} has been duplicated.");
    }
}
