<?php

declare(strict_types=1);

namespace Nova\Stories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Enums\PostTypeVisibility;

class StorePostTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'color' => ['nullable'],
            'description' => ['nullable'],
            'fields' => ['required'],
            'icon' => ['nullable'],
            'key' => ['required'],
            'name' => ['required'],
            'options' => ['required'],
            'role_id' => ['nullable'],
            'status' => ['required', Rule::enum(BasicStatus::class)],
            'visibility' => ['required', Rule::enum(PostTypeVisibility::class)],
        ];
    }

    public function getPostTypeData(): PostTypeData
    {
        return PostTypeData::from($this);
    }
}
