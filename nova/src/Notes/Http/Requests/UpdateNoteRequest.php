<?php

namespace Nova\Notes\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateNoteRequest extends ValidatesRequest
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
