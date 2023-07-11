<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;
use Nova\Media\Rules\MaxFileSize;

class UpdateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize()],
            'name' => ['required'],
            'status' => ['required'],
        ];
    }
}
