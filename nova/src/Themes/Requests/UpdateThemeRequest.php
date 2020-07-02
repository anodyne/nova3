<?php

namespace Nova\Themes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

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
