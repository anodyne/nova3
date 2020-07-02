<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateDepartmentRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
        ];
    }
}
