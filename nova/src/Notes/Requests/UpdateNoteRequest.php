<?php

namespace Nova\Notes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateNoteRequest extends ValidatesRequest
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
