<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable'],
            'name' => ['required'],
        ];
    }
}
