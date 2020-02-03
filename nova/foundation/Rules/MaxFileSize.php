<?php

namespace Nova\Foundation\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxFileSize implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value === null) {
            return true;
        }

        return $value->getSize() <= config('medialibrary.max_file_size');
    }

    public function message()
    {
        return 'The file size is too large.';
    }
}
