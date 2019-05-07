<?php

namespace Nova\Themes\Http\Validators;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Store extends ValidatesRequest
{
    public function messages()
    {
        return [
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
        ];
    }
}
