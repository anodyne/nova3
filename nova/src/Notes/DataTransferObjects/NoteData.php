<?php

namespace Nova\Notes\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class NoteData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $title;

    /**
     * @var  string
     */
    public $content;

    /**
     * @var  string
     */
    public $source;

    /**
     * @var  int
     */
    public $user_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'source' => $request->input('source'),
            'user_id' => auth()->id(),
        ]);
    }
}
