<?php

declare(strict_types=1);

namespace Nova\Ranks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Ranks\Data\RankNameData;

class StoreRankNameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'status' => ['required'],
        ];
    }

    public function getRankNameData(): RankNameData
    {
        return RankNameData::from($this);
    }
}
