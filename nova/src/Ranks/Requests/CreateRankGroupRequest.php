<?php

namespace Nova\Ranks\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateRankGroupRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
