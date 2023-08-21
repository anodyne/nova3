<?php

declare(strict_types=1);

namespace Nova\Themes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Themes\Data\ThemeData;

class StoreThemeRequest extends FormRequest
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

    public function getThemeData(): ThemeData
    {
        return ThemeData::from($this);
    }
}
