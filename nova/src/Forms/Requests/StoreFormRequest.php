<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

use Illuminate\Contracts\Validation\Rule as LegacyValidationRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Forms\Data\FormData;
use Nova\Forms\Enums\FormType;
use Nova\Foundation\Rules\Boolean;

class StoreFormRequest extends FormRequest
{
    /**
     * @return array<
     *     string,
     *     list<string|LegacyValidationRule|ValidationRule>
     * >
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required', 'unique:forms'],
            'type' => ['required', Rule::enum(FormType::class)],
            'description' => ['nullable'],
            'options' => ['sometimes'],
            'status' => ['sometimes', new Boolean],
        ];
    }

    public function getFormData(): FormData
    {
        return FormData::from($this);
    }
}
