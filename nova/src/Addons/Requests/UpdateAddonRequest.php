<?php

declare(strict_types=1);

namespace Nova\Addons\Requests;

use Illuminate\Contracts\Validation\Rule as ValidationRuleContract;

class UpdateAddonRequest extends StoreAddonRequest
{
    /**
     * @return array<string, array<int, ValidationRuleContract|string>>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'location' => ['required'],
        ]);
    }
}
