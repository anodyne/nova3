<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdatePositionRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'available' => ['required', 'numeric', 'min:0'],
            'department_id' => ['required', 'exists:departments,id'],
            'description' => ['nullable'],
            'name' => ['required'],
            'status' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => 'department ID',
        ];
    }
}
