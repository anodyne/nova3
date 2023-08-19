<?php

declare(strict_types=1);

namespace Nova\Ranks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Ranks\Data\RankGroupData;

class StoreRankGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'status' => ['required'],
        ];
    }

    public function getRankGroupData(): RankGroupData
    {
        return RankGroupData::from($this);
    }
}
