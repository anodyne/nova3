<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateFormRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required'],
            'description' => ['nullable'],
        ];
    }
}
