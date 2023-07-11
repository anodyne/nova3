<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        // ray($request->input('assigned_users'));
        // ray($request->input('primary_users'));
        // ray(Arr::accessible($request->all()));
        // ray(Arr::exists($request->all(), 'assigned_users'));
        ray($request->all()['primary_users']);

        return new self(
            users: explode(',', $request->input('assigned_users', '') ?? ''),
            primaryUsers: explode(',', $request->input('primary_users', '') ?? ''),
        );
    }
}
