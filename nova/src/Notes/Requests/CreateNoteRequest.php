<?php

declare(strict_types=1);

namespace Nova\Notes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateNoteRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'content' => ['nullable'],
            'source' => ['nullable'],
            'summary' => ['nullable'],
            'title' => ['required'],
        ];
    }
}
