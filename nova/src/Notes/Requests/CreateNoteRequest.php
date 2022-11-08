<?php

declare(strict_types=1);

namespace Nova\Notes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateNoteRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'content' => ['nullable'],
        ];
    }
}
