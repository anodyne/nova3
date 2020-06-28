<?php

namespace Nova\Ranks\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class CreateRankItemRequest extends ValidatesRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'exists:rank_groups,id'],
            'name_id' => ['required', 'exists:rank_names,id'],
            'base_image' => ['required'],
            'overlay_image' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'group_id' => 'rank group',
            'name_id' => 'rank name',
            'base_image' => 'base image',
            'overlay_image' => 'overlay image',
        ];
    }
}
