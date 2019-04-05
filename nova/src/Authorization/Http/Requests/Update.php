<?php

namespace Nova\Authorization\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Update extends BaseFormRequest
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
