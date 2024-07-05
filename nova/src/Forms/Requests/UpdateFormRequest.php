<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

class UpdateFormRequest extends StoreFormRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        unset($rules['key']);
        unset($rules['type']);

        return $rules;
    }
}
