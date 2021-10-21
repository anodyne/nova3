<?php

declare(strict_types=1);

namespace Nova\Characters\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class CharacterData extends DataTransferObject
{
    public string $name;

    public ?int $rank_id;

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->name,
            rank_id: (int) $request->rank_id,
        );
    }
}
