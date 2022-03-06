<?php

declare(strict_types=1);

namespace Nova\Notes\Data;

use Illuminate\Http\Request;
use Nova\Users\Models\User;
use Spatie\LaravelData\Data;

class NoteData extends Data
{
    public function __construct(
        public string $title,
        public ?string $content,
        public ?User $user
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            title: $request->input('title'),
            content: $request->input('editor-content'),
            user: auth()->user(),
        );
    }
}
