<?php

declare(strict_types=1);

namespace Nova\Addons\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Enums\AddonType;

class StoreAddonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'location' => ['required', 'unique:addons,location'],
            'version' => ['nullable'],
            'credits' => ['nullable'],
            'type' => [Rule::enum(AddonType::class)],
            'preview' => ['nullable'],
            'status' => ['nullable'],
        ];
    }

    public function getAddonData(): AddonData
    {
        return AddonData::from($this);
    }
}
