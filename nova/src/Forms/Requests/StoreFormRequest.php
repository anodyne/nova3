<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Forms\Data\FormData;
use Nova\Forms\Enums\FormType;
use Nova\Foundation\Enums\BasicStatus;

class StoreFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required', 'unique:forms'],
            'type' => ['required', Rule::enum(FormType::class)],
            'description' => ['nullable'],
            'options' => ['sometimes'],
            'status' => ['required', Rule::enum(BasicStatus::class)],
        ];
    }

    public function getFormData(): FormData
    {
        return FormData::from($this);
    }
}
