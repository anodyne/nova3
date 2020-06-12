<?php

namespace Nova\Roles\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

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
