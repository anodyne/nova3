<?php

namespace Nova\Themes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class InstallThemeRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'theme' => ['required'],
        ];
    }
}
