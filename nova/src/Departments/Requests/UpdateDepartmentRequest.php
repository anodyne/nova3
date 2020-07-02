<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

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
