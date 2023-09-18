<?php

declare(strict_types=1);

namespace Nova\Stories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Data\StoryPositionData;

class StoreStoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['nullable'],
            'started_at' => ['nullable'],
            'ended_at' => ['nullable'],
            'summary' => ['nullable'],
            'parent_id' => ['nullable', 'exists:stories,id'],
            'display_direction' => ['nullable'],
            'display_neighbor' => ['nullable'],
        ];
    }

    public function getStoryData(): StoryData
    {
        return StoryData::from($this);
    }

    public function getStoryPositionData(): StoryPositionData
    {
        return StoryPositionData::from($this);
    }
}
