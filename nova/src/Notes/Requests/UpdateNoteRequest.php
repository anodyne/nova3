<?php

namespace Nova\Notes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

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
