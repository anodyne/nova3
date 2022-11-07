<?php

declare(strict_types=1);

namespace Nova\Notes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Notes\Models\Note;
use Nova\Notes\Responses\ShowAllNotesResponse;
use Nova\Notes\Responses\ShowNoteResponse;

class ShowNoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(): Responsable
    {
        $this->authorize('viewAny', Note::class);

        return ShowAllNotesResponse::send();
    }

    public function show(Note $note): Responsable
    {
        $this->authorize('view', $note);

        return ShowNoteResponse::sendWith([
            'note' => $note,
        ]);
    }
}
