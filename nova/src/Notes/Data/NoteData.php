<?php

declare(strict_types=1);

namespace Nova\Notes\Data;

use Nova\Users\Models\User;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class NoteData extends Data
{
    public function __construct(
        public string $title,

        #[MapInputName('editor-content')]
        public ?string $content
    ) {
    }

    public function user(): User
    {
        return auth()->user();
    }
}
