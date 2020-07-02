<?php

namespace Nova\Roles\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateRoleRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'display_name' => ['required'],
            'permissions' => ['nullable'],
            'users' => ['nullable'],
            'default' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => 'The name field is required.',
            'name.required' => 'The key field is required.',
        ];
    }
}
