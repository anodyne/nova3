<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Spatie\LaravelData\Data;

class AssignUserCharactersData extends Data
{
    public function __construct(
        public ?array $characters,
        public ?Character $primaryCharacter,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            characters: ($request->characters) ? explode(',', $request->characters) : [],
            primaryCharacter: Character::find($request->primary_character),
        );
    }
}
