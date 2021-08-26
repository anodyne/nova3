<?php

declare(strict_types=1);

namespace Nova\Themes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateThemeRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'active' => ['nullable'],
            'credits' => ['nullable'],
            'location' => ['required', 'unique:themes,location'],
            'name' => ['required'],
            'variants' => ['nullable'],
        ];
    }
}
