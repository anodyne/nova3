<?php

namespace Nova\Themes\Http\Validators;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Update extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'credits' => ['nullable'],
        ];
    }
}
