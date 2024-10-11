<?php

declare(strict_types=1);

namespace Nova\Themes\Requests;

class UpdateThemeRequest extends StoreThemeRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'location' => ['required'],
        ]);
    }
}
