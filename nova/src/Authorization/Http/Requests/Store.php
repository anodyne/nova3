<?php

namespace Nova\Authorization\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
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
