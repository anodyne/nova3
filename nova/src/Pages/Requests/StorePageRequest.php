<?php

declare(strict_types=1);

namespace Nova\Pages\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Stories\Data\PostTypeData;

class StorePageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required'],
            'description' => ['nullable'],
            'color' => ['nullable'],
            'icon' => ['nullable'],
            'fields' => ['required'],
            'key' => ['required'],
            'name' => ['required'],
            'options' => ['required'],
            'role_id' => ['nullable'],
            'visibility' => ['required', 'in:in-character,out-of-character'],
        ];
    }

    public function getPageData(): PostTypeData
    {
        return PostTypeData::from($this);
    }
}
