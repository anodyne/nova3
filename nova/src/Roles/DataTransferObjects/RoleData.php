<?php

namespace Nova\Roles\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RoleData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $display_name;

    /**
     * @var  string
     */
    public $description;

    /**
     * @var  array
     */
    public $permissions;

    /**
     * @var  array
     */
    public $users;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'description' => $request->input('description'),
            'display_name' => $request->input('display_name'),
            'name' => $request->input('name'),
            'permissions' => $request->input('permissions'),
            'users' => $request->input('users'),
        ]);
    }
}
