<?php

declare(strict_types=1);

namespace Nova\Addons\Requests;

class UpdateAddonRequest extends StoreAddonRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'location' => ['required'],
        ]);
    }
}
