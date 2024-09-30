<?php

declare(strict_types=1);

namespace Nova\Announcements\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Announcements\Data\AnnouncementData;

class StoreAnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'category' => ['nullable'],
            'published_at' => ['nullable'],
            'content' => ['nullable'],
        ];
    }

    public function getAnnouncementData(): AnnouncementData
    {
        return AnnouncementData::from($this);
    }
}
