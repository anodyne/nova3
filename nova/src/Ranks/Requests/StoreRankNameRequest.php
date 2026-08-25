<?php

declare(strict_types=1);

namespace Nova\Ranks\Requests;

use Illuminate\Contracts\Validation\Rule as ValidationRuleContract;
use Illuminate\Foundation\Http\FormRequest;
use Nova\Ranks\Data\RankNameData;

class StoreRankNameRequest extends FormRequest
{
    /**
     * @return array<string, array<int, ValidationRuleContract|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'status' => ['sometimes'],
        ];
    }

    public function getRankNameData(): RankNameData
    {
        return RankNameData::from($this);
    }
}
