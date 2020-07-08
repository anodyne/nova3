<?php

namespace Nova\Characters\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateCharacterRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'positions' => ['required'],
            'rank_id' => ['nullable'],
            'users' => ['nullable'],
        ];
    }
}
