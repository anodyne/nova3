<?php

namespace Nova\Characters\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateCharacterRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'rank_id' => ['nullable'],
            'type' => ['required'],
        ];
    }
}
