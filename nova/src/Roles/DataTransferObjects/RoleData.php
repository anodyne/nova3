<?php

namespace Nova\Roles\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Roles\Models\Permission;
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
     * @var  bool
     */
    public $default;

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
            'permissions' => Permission::whereIn('id', $request->input('permissions', []))->get(),
            'users' => $request->input('users'),
            'default' => $request->input('default'),
        ]);
    }
}
