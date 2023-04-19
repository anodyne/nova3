<?php

declare(strict_types=1);

namespace Nova\Ranks\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class UpdateRankNameRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'status' => ['required'],
        ];
    }
}
