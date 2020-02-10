<?php

namespace Nova\Themes\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Install extends ValidatesRequest
{
    public function rules()
    {
        return [
            'theme' => ['required'],
        ];
    }
}
