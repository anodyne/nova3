<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Story;

class UpdateStoryStatus extends Action
{
    public function handle(Story $story, string $status): Story
    {
        if ($status !== $story->status->name()) {
            $story->status->transitionTo($status);
        }

        return $story->refresh();
    }
}
