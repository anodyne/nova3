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
            'description' => ['nullable'],
            'display_name' => ['required'],
            'name' => ['required', 'unique:roles'],
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
