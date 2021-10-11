<?php

declare(strict_types=1);

namespace Nova\Notes\Controllers;

use Illuminate\Http\RedirectResponse;
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

    public function __invoke(Note $original): RedirectResponse
    {
        $this->authorize('duplicate', $original);

        $note = DuplicateNote::run($original);

        NoteDuplicated::dispatch($note, $original);

        return redirect()
            ->route('notes.edit', $note)
            ->withToast("{$original->title} was duplicated");
    }
}
