<?php

namespace Nova\Themes\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Update extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'credits' => ['nullable'],
        ];
    }
}
