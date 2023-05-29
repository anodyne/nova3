<?php

declare(strict_types=1);

namespace Nova\Foundation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxFileSize implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value && $value->getSize() > config('medialibrary.max_file_size')) {
            $fail('The file size is too large');
        }
    }
}
