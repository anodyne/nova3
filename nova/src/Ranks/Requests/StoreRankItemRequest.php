<?php

declare(strict_types=1);

namespace Nova\Ranks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Ranks\Data\RankItemData;

class StoreRankItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'exists:rank_groups,id'],
            'name_id' => ['required', 'exists:rank_names,id'],
            'base_image' => ['required'],
            'overlay_image' => ['nullable'],
            'status' => ['required'],
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

    public function getRankItemData(): RankItemData
    {
        return RankItemData::from($this);
    }
}
