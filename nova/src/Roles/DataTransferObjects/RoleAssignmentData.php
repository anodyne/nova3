<?php

declare(strict_types=1);

namespace Nova\Roles\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Roles\Models\Role;
use Nova\Users\Models\Collections\UsersCollection;
use Nova\Users\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class RoleAssignmentData extends DataTransferObject
{
    public ?Role $role;

    public ?UsersCollection $users;

    public static function fromRequest(Request $request): self
    {
        return new self(
            role: Role::find($request->input('id')),
            users: User::whereIn('id', $request->input('users', []))->get(),
        );
    }
}
