<?php

namespace Nova\Ranks\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateRankNameRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
