<?php

declare(strict_types=1);

namespace Nova\Forms\Requests;

class UpdateFormRequest extends StoreFormRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'key' => ['required'],
        ]);
    }
}
