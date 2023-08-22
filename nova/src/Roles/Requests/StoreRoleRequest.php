<?php

declare(strict_types=1);

namespace Nova\Roles\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Foundation\Rules\Boolean;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Data\RolePermissionsData;
use Nova\Roles\Data\RoleUsersData;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'default' => ['sometimes', new Boolean()],
            'description' => ['nullable'],
            'display_name' => ['required'],
            'name' => ['required', Rule::unique('roles')->ignore($this->role)],
        ];
    }

    public function attributes(): array
    {
        return [
            'display_name' => 'name',
            'name' => 'key',
        ];
    }

    public function getRoleData(): RoleData
    {
        return RoleData::from($this);
    }

    public function getRolePermissionsData(): RolePermissionsData
    {
        return RolePermissionsData::from($this);
    }

    public function getRoleUsersData(): RoleUsersData
    {
        return RoleUsersData::from($this);
    }
}
