<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Illuminate\Validation\Rule;

class UpdateUserRequest extends StoreUserRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ],
        ]);
    }
}
