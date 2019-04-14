<?php

namespace Nova\Themes\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
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
