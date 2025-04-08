<?php

declare(strict_types=1);

namespace Nova\Announcements\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Foundation\Enums\PublishStatus;

class StoreAnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'category' => ['nullable', 'string'],
            'status' => ['nullable', Rule::enum(PublishStatus::class)],
            'content' => ['nullable', 'string'],
        ];
    }

    public function getAnnouncementData(): AnnouncementData
    {
        return AnnouncementData::from($this);
    }
}
