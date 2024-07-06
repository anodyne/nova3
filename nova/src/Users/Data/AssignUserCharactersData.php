<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class AssignUserCharactersData extends Data
{
    public function __construct(
        public ?array $characters,
        public ?int $primaryCharacter
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new self(
            characters: explode(',', $request->input('assigned_characters', '') ?? ''),
            primaryCharacter: $request->integer('primary_character', null),
        );
    }
}
