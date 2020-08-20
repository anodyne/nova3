<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Rules\MaxFileSize;
use Nova\Foundation\Requests\ValidatesRequest;

class CreateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
            'name' => ['required'],
        ];
    }
}
