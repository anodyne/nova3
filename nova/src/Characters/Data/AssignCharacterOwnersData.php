<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class AssignCharacterOwnersData extends Data
{
    public function __construct(
        public array $users,
        public ?array $primaryCharacters
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            users: $request->input('users', []),
            primaryCharacters: $request->input('primaryCharacters', []),
        );
    }
}
