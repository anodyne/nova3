<?php

declare(strict_types=1);

namespace Nova\Pages\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Pages\Data\PageData;
use Nova\Pages\Enums\PageVerb;

class StorePageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'heading' => ['nullable'],
            'intro' => ['nullable'],
            'key' => ['required'],
            'name' => ['required'],
            'resource' => ['nullable'],
            'seo_description' => ['nullable'],
            'seo_keywords' => ['nullable'],
            'seo_title' => ['nullable'],
            'status' => ['sometimes'],
            'subheading' => ['nullable'],
            'uri' => ['required'],
            'verb' => ['required', Rule::enum(PageVerb::class)],
        ];
    }

    public function getPageData(): PageData
    {
        return PageData::from($this);
    }
}
