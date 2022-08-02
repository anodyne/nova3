<?php

declare(strict_types=1);

namespace Nova\Notes\Data;

use Illuminate\Http\Request;
use Nova\Users\Models\User;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class NoteData extends Data
{
    public function __construct(
        #[Required, StringType()]
        public string $title,

        #[Nullable, StringType()]
        public ?string $content,

        #[Nullable]
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
