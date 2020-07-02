<?php

namespace Nova\Notes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateNoteRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'content' => ['nullable'],
            'source' => ['nullable'],
            'summary' => ['nullable'],
        ];
    }
}
