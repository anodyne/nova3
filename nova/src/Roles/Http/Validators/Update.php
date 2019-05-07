<?php

namespace Nova\Roles\Http\Validators;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Update extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'title' => 'required',
            'abilities' => 'nullable',
        ];
    }
}
