<?php

declare(strict_types=1);

namespace Nova\Addons\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Addons\Data\AddonData;

class StoreAddonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'active' => ['nullable'],
            'credits' => ['nullable'],
            'location' => ['required', 'unique:addons,location'],
            'name' => ['required'],
            'settings' => ['nullable'],
        ];
    }

    public function getAddonData(): AddonData
    {
        return AddonData::from($this);
    }
}
