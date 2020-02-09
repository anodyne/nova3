<?php

namespace Nova\Roles\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateUpdateRole extends ValidatesRequest
{
    public function validationData()
    {
        if ($this->route('role')->locked) {
            return $this->except('name');
        }

        return $this->all();
    }

    public function rules()
    {
        return [
            'name' => ['sometimes'],
            'display_name' => ['required'],
            'permissions' => ['nullable'],
            'users' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => 'The name field is required.',
            'name.sometimes' => 'The key field is required.',
        ];
    }
}
