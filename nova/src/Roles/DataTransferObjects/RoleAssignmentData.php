<?php

namespace Nova\Roles\DataTransferObjects;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Nova\Users\Models\Collections\UsersCollection;

class RoleAssignmentData extends DataTransferObject
{
    public ?Role $role;

    public ?UsersCollection $users;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'role' => Role::find($request->input('id')),
            'users' => User::whereIn('id', $request->input('users', []))->get(),
        ]);
    }
}
