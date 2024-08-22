<?php

declare(strict_types=1);

namespace Nova\Conversations\Controllers;

use Illuminate\Http\RedirectResponse;
use Nova\Conversations\Responses\ListConversationsResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;
use Nova\Notes\Requests\CreateNoteRequest;
use Nova\Notes\Requests\UpdateNoteRequest;
use Nova\Notes\Responses\CreateNoteResponse;
use Nova\Notes\Responses\EditNoteResponse;
use Nova\Notes\Responses\ShowNoteResponse;

class ConversationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        // $this->authorizeResource(Note::class);
    }

    public function index(): Responsable
    {
        return ListConversationsResponse::send();
    }

    public function show(Note $note): Responsable
    {
        return ShowNoteResponse::sendWith([
            'note' => $note,
        ]);
    }

    public function create(): Responsable
    {
        return CreateNoteResponse::send();
    }

    public function store(CreateNoteRequest $request): RedirectResponse
    {
        $note = CreateNote::run(NoteData::from($request));

        return redirect()
            ->route('admin.notes.index')
            ->notify("{$note->title} was created");
    }

    public function edit(Note $note): Responsable
    {
        $this->authorize('update', $note);

        return EditNoteResponse::sendWith([
            'note' => $note,
        ]);
    }

    public function update(UpdateNoteRequest $request, Note $note): RedirectResponse
    {
        $this->authorize('update', $note);

        $note = UpdateNote::run($note, NoteData::from($request));

        return back()->notify("{$note->title} was updated");
    }
}
