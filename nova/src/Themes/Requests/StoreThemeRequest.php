<?php

declare(strict_types=1);

namespace Nova\Themes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Themes\Data\ThemeData;

class StoreThemeRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'active' => ['nullable'],
            'credits' => ['nullable'],
            'location' => ['required', 'unique:themes,location'],
            'name' => ['required'],
            'settings' => ['nullable'],
        ];
    }

    public function getThemeData(): ThemeData
    {
        return ThemeData::from($this);
    }
}
