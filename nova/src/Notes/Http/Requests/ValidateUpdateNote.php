<?php

namespace Nova\Notes\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateUpdateNote extends ValidatesRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'content' => ['nullable'],
        ];
    }
}
