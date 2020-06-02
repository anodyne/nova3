<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Illuminate\Http\Request;
use Nova\Notes\Http\Responses\ShowNoteResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Notes\Http\Responses\ShowAllNotesResponse;

class ShowNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request)
    {
        $this->authorize('viewAny', Note::class);

        $notes = Note::whereAuthor(auth()->user())
            ->orderBy('title')
            ->filter($request->only('search'))
            ->paginate();

        return app(ShowAllNotesResponse::class)->with([
            'filters' => $request->all('search'),
            'notes' => $notes,
        ]);
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);

        return app(ShowNoteResponse::class)->with([
            'note' => $note,
        ]);
    }
}
