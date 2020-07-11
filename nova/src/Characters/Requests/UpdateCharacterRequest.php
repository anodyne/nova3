<?php

namespace Nova\Characters\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateCharacterRequest extends ValidatesRequest
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
