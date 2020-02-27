<?php

namespace Nova\Notes\Http\Controllers;

use Nova\Notes\Models\Note;
use Illuminate\Http\Request;
use Nova\Foundation\Http\Controllers\Controller;

class SearchNotesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $notes = Note::whereAuthor(auth()->user())
            ->orderBy('title')
            ->filter($request->only('search'))
            ->get();

        return response()->json($notes, 200);
    }
}
