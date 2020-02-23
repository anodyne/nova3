<?php

namespace Nova\Notes\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateStoreNote extends ValidatesRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'content' => ['nullable'],
        ];
    }
}
