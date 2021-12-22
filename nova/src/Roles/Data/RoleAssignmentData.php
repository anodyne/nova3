<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Http\Request;
use Nova\Roles\Models\Role;
use Nova\Users\Models\Collections\UsersCollection;
use Nova\Users\Models\User;
use Spatie\LaravelData\Data;

class RoleAssignmentData extends Data
{
    public function __construct(
        public ?Role $role,
        public ?UsersCollection $users,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            role: Role::find($request->input('id')),
            users: User::whereIn('id', $request->input('users', []))->get(),
        );
    }
}
