<?php

namespace Nova\Themes\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateThemeRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'credits' => ['nullable'],
            'active' => ['required'],
        ];
    }
}
