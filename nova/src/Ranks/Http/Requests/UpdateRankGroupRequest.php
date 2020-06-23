<?php

namespace Nova\Ranks\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateRankGroupRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
