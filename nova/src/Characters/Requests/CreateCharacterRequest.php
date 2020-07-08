<?php

namespace Nova\Characters\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateCharacterRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'rank_id' => ['nullable'],
            // 'type' => ['required'],
        ];
    }
}
