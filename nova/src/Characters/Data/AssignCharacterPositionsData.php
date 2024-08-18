<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class AssignCharacterPositionsData extends Data
{
    public function __construct(
        public ?array $positions
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            positions: explode(',', data_get($data, 'position', '') ?? '')
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            positions: explode(',', $request->input('assigned_positions', '') ?? '')
        );
    }
}
