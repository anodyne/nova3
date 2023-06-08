<?php

declare(strict_types=1);

namespace Nova\Roles\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;
use Nova\Foundation\Rules\Boolean;

class UpdateRoleRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'default' => ['sometimes', new Boolean()],
            'description' => ['nullable'],
            'display_name' => ['required'],
            'name' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'display_name' => 'name',
            'name' => 'key',
        ];
    }
}
