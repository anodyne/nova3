<?php

namespace Nova\Roles\Http\Validators;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Store extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:roles',
            'title' => 'required',
            'abilities' => 'nullable',
        ];
    }
}
