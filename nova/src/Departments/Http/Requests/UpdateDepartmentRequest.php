<?php

namespace Nova\Departments\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateDepartmentRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
            'active' => ['required'],
        ];
    }
}
