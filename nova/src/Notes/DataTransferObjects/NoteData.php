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
     * @var  User
     */
    public $user;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'content' => $request->content,
            'source' => $request->source,
            'summary' => $request->summary,
            'title' => $request->title,
            'user' => auth()->user(),
        ]);
    }
}
