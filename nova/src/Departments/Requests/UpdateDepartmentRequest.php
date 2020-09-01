<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Rules\MaxFileSize;
use Nova\Foundation\Requests\ValidatesRequest;

class UpdateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required'],
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
            'name' => ['required'],
        ];
    }
}
