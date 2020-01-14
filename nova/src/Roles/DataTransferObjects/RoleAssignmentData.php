<?php

namespace Nova\Roles\DataTransferObjects;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RoleAssignmentData extends DataTransferObject
{
    /**
     * @var  Role
     */
    public $role;

    /**
     * @var  User[]
     */
    public $users;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'role' => Role::find($request->get('id')),
            'users' => User::whereIn('id', $request->get('users'))->get(),
        ]);
    }
}
