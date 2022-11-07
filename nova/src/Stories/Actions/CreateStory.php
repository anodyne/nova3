<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Story;

class CreateStory
{
    use AsAction;

    public function handle(StoryData $data): Story
    {
        return DB::transaction(function () use ($data) {
            $story = Story::create(
                $data->except('parent', 'parent_id')->all()
            );

            $story->appendToNode($data->parent)->save();

            return $story;
        });
    }
}
