<?php

namespace Nova\Ranks\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class CreateRankGroupRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
