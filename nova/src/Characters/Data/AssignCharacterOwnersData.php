<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class AssignCharacterOwnersData extends Data
{
    public function __construct(
        public ?array $users,
        public ?array $primaryUsers
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            users: explode(',', $request->input('assigned_users', '') ?? ''),
            primaryUsers: explode(',', $request->input('primary_users', '') ?? ''),
        );
    }
}
