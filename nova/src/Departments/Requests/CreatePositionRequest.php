<?php

namespace Nova\Departments\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreatePositionRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'available' => ['required', 'numeric', 'min:0'],
            'department_id' => ['required', 'exists:departments,id'],
            'description' => ['nullable'],
            'name' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => 'department ID',
        ];
    }
}
