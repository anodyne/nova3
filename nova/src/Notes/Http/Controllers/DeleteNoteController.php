<?php

namespace Nova\Notes\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DeleteNote;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Notes\Http\Responses\DeleteNoteResponse;

class DeleteNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $note = Note::findOrFail($request->id);

        return app(DeleteNoteResponse::class)->with([
            'note' => $note,
        ]);
    }

    public function destroy(Note $note, DeleteNote $action)
    {
        $this->authorize('delete', $note);

        $action->execute($note);

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} was deleted.");
    }
}
