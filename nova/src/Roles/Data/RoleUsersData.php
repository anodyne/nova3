<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class RoleUsersData extends Data
{
    public function __construct(
        public ?array $users
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            users: collect(explode(',', $request->input('assigned_users') ?? ''))->filter()->all()
        );
    }
}
