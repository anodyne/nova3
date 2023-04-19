<?php

declare(strict_types=1);

namespace Nova\PostTypes\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdatePostTypeRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required'],
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
