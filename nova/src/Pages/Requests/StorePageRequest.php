<?php

declare(strict_types=1);

namespace Nova\Pages\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Pages\Data\PageData;

class StorePageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'uri' => ['required'],
            'key' => ['required'],
            'verb' => ['required'],
            'resource' => ['nullable'],
        ];
    }

    public function getPageData(): PageData
    {
        return PageData::from($this);
    }
}
