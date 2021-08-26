<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;
use Nova\Foundation\Rules\MaxFileSize;

class UpdateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required'],
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize()],
            'name' => ['required'],
        ];
    }
}
