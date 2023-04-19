<?php

declare(strict_types=1);

namespace Nova\Characters\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class CreateCharacterRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'positions' => ['required'],
            'rank_id' => ['nullable'],
            'users' => ['nullable'],
        ];
    }
}
