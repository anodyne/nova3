<?php

declare(strict_types=1);

namespace Nova\Themes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class InstallThemeRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'theme' => ['required'],
        ];
    }
}
