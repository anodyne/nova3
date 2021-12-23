<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateFormRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required', 'unique:forms'],
            'description' => ['nullable'],
        ];
    }
}
