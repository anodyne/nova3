<?php

namespace Nova\PostTypes\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreatePostTypeRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required'],
            'description' => ['nullable'],
            'color' => ['nullable'],
            'icon' => ['nullable'],
            'fields' => ['required'],
            'key' => ['required'],
            'name' => ['required'],
            'options' => ['required'],
            'role_id' => ['nullable'],
            'visibility' => ['required', 'in:in-character,out-of-character'],
        ];
    }
}
