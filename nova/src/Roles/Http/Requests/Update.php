<?php

namespace Nova\Roles\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Update extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'display_name' => ['required'],
            'permissions' => ['nullable'],
        ];
    }
}
