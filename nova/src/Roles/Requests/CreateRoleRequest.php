<?php

namespace Nova\Roles\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateRoleRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:roles'],
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
            'name.unique' => 'That value already exists. Please choose a unique key.',
        ];
    }
}
