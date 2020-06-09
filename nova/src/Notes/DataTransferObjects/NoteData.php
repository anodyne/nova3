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
     * @var  string
     */
    public $summary;

    /**
     * @var  int
     */
    public $user_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'title' => $request->title,
            'content' => $request->content,
            'source' => $request->source,
            'summary' => $request->summary,
            'user_id' => auth()->id(),
        ]);
    }
}
