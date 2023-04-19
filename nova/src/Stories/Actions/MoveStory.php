<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class MoveStory
{
    use AsAction;

    public function handle(Story $story, ?Story $newParent): Story
    {
        return tap($story)
            ->update(['parent_id' => $newParent?->id])
            ->refresh();
    }
}
