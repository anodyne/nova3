<?php

namespace Nova\Roles\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateStoreRole extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:roles'],
            'display_name' => ['required'],
            'permissions' => ['nullable'],
        ];
    }
}
