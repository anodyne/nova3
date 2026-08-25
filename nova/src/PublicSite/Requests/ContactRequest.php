<?php

declare(strict_types=1);

namespace Nova\PublicSite\Requests;

use Illuminate\Contracts\Validation\Rule as ValidationRuleContract;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * @return array<string, array<int, ValidationRuleContract|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required'],
        ];
    }
}
