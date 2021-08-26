<?php

declare(strict_types=1);

namespace Nova\Roles\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateRoleRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'default' => ['sometimes'],
            'display_name' => ['required'],
            'name' => ['required', 'unique:roles'],
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
