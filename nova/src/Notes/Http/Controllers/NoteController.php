<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Illuminate\Http\Request;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\Http\Resources\NoteResource;
use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Http\Resources\NoteCollection;
use Nova\Notes\Http\Requests\ValidateStoreNote;
use Nova\Notes\Http\Responses\EditNoteResponse;
use Nova\Notes\Http\Responses\ViewNoteResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Notes\Http\Requests\ValidateUpdateNote;
use Nova\Notes\Http\Responses\NoteIndexResponse;
use Nova\Notes\Http\Responses\CreateNoteResponse;

class NoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Note::class);
    }

    public function index(Request $request)
    {
        $notes = Note::whereAuthor(auth()->user())
            ->orderBy('title')
            ->filter($request->only('search'))
            ->paginate();

        return app(NoteIndexResponse::class)->with([
            'filters' => $request->all('search'),
            'notes' => new NoteCollection($notes),
        ]);
    }

    public function show(Note $note)
    {
        return app(ViewNoteResponse::class)->with([
            'note' => new NoteResource($note),
        ]);
    }

    public function create()
    {
        return app(CreateNoteResponse::class);
    }

    public function store(ValidateStoreNote $request, CreateNote $action)
    {
        $note = $action->execute(NoteData::fromRequest($request));

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} note was created.");
    }

    public function edit(Note $note)
    {
        return app(EditNoteResponse::class)->with([
            'note' => new NoteResource($note),
        ]);
    }

    public function update(
        ValidateUpdateNote $request,
        Note $note,
        UpdateNote $action
    ) {
        $note = $action->execute($note, NoteData::fromRequest($request));

        return back()->withToast("{$note->title} was updated.");
    }

    public function destroy(Note $note, DeleteNote $action)
    {
        $action->execute($note);

        return redirect()
            ->route('notes.index')
            ->withToast("{$note->title} was deleted.");
    }
}
