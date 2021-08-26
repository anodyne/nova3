<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;
use Nova\Foundation\Rules\MaxFileSize;

class CreateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize()],
            'name' => ['required'],
        ];
    }
}
