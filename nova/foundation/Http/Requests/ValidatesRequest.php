<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ValidatesRequest extends FormRequest
{
    /**
     * Is the current user authorized to take the action on this request?
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The validation rules for this request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * The validation messages for this request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [];
    }
}
