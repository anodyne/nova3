<?php

namespace Nova\Themes\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Install extends BaseFormRequest
{
    public function rules()
    {
        return [
            'theme' => 'required|unique:themes',
        ];
    }
}
