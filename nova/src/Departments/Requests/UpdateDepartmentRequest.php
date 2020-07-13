<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateDepartmentRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required'],
            'description' => ['nullable'],
            'name' => ['required'],
        ];
    }
}
