<?php

namespace Nova\Themes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateThemeRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required'],
            'credits' => ['nullable'],
            'name' => ['required'],
        ];
    }
}
