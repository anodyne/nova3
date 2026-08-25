<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

use Illuminate\Contracts\Validation\Rule as LegacyValidationRule;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateFormRequest extends StoreFormRequest
{
    /**
     * @return array<
     *     string,
     *     list<string|LegacyValidationRule|ValidationRule>
     * >
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'key' => ['required'],
        ]);
    }
}
