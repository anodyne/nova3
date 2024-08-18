<?php

declare(strict_types=1);

namespace Nova\Departments\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Departments\Data\DepartmentData;
use Nova\Media\Rules\MaxFileSize;

class StoreDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
            'image' => ['nullable', 'mimes:jpg,jpeg,png,gif,webp,svg', new MaxFileSize],
            'status' => ['required'],
        ];
    }

    public function getDepartmentData(): DepartmentData
    {
        return DepartmentData::from($this);
    }
}
