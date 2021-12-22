<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class CharacterData extends Data
{
    public function __construct(
        public string $name,
        public ?int $rank_id
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->name,
            rank_id: (int) $request->rank_id,
        );
    }
}
