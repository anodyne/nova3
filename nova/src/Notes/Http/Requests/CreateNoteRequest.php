<?php

namespace Nova\Notes\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

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
