<?php

namespace Nova\Departments\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

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
