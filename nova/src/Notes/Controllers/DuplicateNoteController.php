<?php

declare(strict_types=1);

namespace Nova\Notes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Notes\Models\Note;

class DuplicateNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(
        DuplicateNote $action,
        Note $originalNote
    ) {
        $this->authorize('duplicate', $originalNote);

        $note = $action->execute($originalNote);

        NoteDuplicated::dispatch($note, $originalNote);

        return redirect()
            ->route('notes.edit', $note)
            ->withToast("{$originalNote->title} was duplicated");
    }
}
