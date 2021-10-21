<?php

declare(strict_types=1);

namespace Nova\Notes\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Models\Note;
use Nova\Notes\Responses\DeleteNoteResponse;

class DeleteNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request): Responsable
    {
        $note = Note::findOrFail($request->id);

        return DeleteNoteResponse::sendWith([
            'note' => $note,
        ]);
    }

    public function destroy(Note $note): RedirectResponse
    {
        $this->authorize('delete', $note);

        DeleteNote::run($note);

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} was deleted.");
    }
}
