<?php

namespace Nova\Stories\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateStoryRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['nullable'],
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
            'summary' => ['nullable'],
            'parent_id' => ['nullable'],
        ];
    }
}
