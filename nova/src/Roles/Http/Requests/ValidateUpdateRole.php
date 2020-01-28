<?php

namespace Nova\Roles\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateUpdateRole extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:roles'],
            'display_name' => ['required'],
            'permissions' => ['nullable'],
            'users' => ['nullable'],
        ];
    }

    public function users()
    {
        return [
            'display_name.required' => 'The name field is required.',
            'name.required' => 'The key field is required.',
            'name.unique' => 'That value already exists. Please choose a unique key.',
        ];
    }
}
