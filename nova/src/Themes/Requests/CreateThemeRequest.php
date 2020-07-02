<?php

namespace Nova\Themes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateThemeRequest extends ValidatesRequest
{
    public function messages()
    {
        return [
            'name.required' => 'Please enter a theme name',
            'location.required' => 'Please enter a theme location',
            'location.unique' => 'A theme already exists at that location.',
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'location' => ['required', 'unique:themes,location'],
            'credits' => ['nullable'],
            'variants' => ['nullable'],
            'active' => ['nullable'],
        ];
    }
}
