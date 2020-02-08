<?php

namespace Nova\Users\DataTransferObjects;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $email;

    /**
     * @var  string
     */
    public $gender;

    /**
     * @var  Role[]
     */
    public $roles;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'roles' => Role::whereIn('name', $request->input('roles'))->get(),
        ]);
    }
}
