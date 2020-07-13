<?php

namespace Nova\Ranks\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateRankNameRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
