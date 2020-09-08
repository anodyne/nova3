<?php

namespace Nova\Roles\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Roles\Models\Permission;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class RoleData extends DataTransferObject
{
    public string $name;

    public string $display_name;

    public ?string $description;

    public ?Collection $permissions;

    public bool $default;

    public ?array $users;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'default' => (bool) $request->input('default', false),
            'description' => $request->input('description'),
            'display_name' => $request->input('display_name'),
            'name' => $request->input('name'),
            'permissions' => Permission::whereIn('id', $request->input('permissions', []))->get(),
            'users' => $request->input('users'),
        ]);
    }
}
