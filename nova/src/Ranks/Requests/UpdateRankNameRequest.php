<?php

declare(strict_types=1);

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
