<?php

namespace Nova\Roles\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateRoleRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'default' => ['sometimes'],
            'display_name' => ['required'],
            'name' => ['required'],
            'permissions' => ['nullable'],
            'users' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'display_name' => 'name',
            'name' => 'key',
        ];
    }
}
