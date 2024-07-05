<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Forms\Data\FormData;

class StoreFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required', 'unique:forms'],
            'type' => ['required', 'in:advanced,basic'],
            'description' => ['nullable'],
            'options' => ['sometimes'],
        ];
    }

    public function getFormData(): FormData
    {
        return FormData::from($this);
    }
}
