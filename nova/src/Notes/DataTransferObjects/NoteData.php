<?php

declare(strict_types=1);

namespace Nova\Notes\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Users\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class NoteData extends DataTransferObject
{
    public string $title;

    public ?string $content;

    public ?string $source;

    public ?string $summary;

    public ?User $user;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'content' => $request->input('editor-content'),
            // 'source' => $request->source,
            'summary' => $request->summary,
            'title' => $request->title,
            'user' => auth()->user(),
        ]);
    }
}
