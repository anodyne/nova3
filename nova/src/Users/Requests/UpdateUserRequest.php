<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Illuminate\Validation\Rule;
use Nova\Media\Rules\MaxFileSize;

class UpdateUserRequest extends StoreUserRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'avatar' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize()],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ],
        ]);
    }
}
