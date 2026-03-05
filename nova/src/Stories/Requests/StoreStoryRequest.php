<?php

declare(strict_types=1);

namespace Nova\Stories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Media\Enums\ImageAction;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Data\StoryPositionData;
use Nova\Stories\Enums\PositionDirection;

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
            'display_direction' => ['nullable', Rule::enum(PositionDirection::class)],
            'display_neighbor' => ['nullable'],
            'status' => ['required'],
        ];
    }

    public function getImageAction(): ImageAction
    {
        return $this->enum('image_action', ImageAction::class) ?? ImageAction::Unchanged;
    }

    public function getImageTempPath(): ?string
    {
        return $this->string('image_temp_path')->toString() ?: null;
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
