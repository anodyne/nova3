<?php

declare(strict_types=1);

namespace Nova\Ranks\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class UpdateRankItemRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'group_id' => ['required', 'exists:rank_groups,id'],
            'name_id' => ['required', 'exists:rank_names,id'],
            'base_image' => ['required'],
            'overlay_image' => ['nullable'],
            'status' => ['required'],
        ];
    }
}
