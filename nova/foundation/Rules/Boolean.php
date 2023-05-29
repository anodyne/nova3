<?php

declare(strict_types=1);

namespace Nova\Foundation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Boolean implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            $fail('validation.boolean')->translate();
        }
    }
}
