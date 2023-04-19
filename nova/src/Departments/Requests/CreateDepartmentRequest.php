<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;
use Nova\Foundation\Rules\MaxFileSize;

class CreateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize()],
        ];
    }
}
