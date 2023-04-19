<?php

declare(strict_types=1);

namespace Nova\Notes\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateNoteRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'content' => ['nullable'],
        ];
    }
}
