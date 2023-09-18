<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class UpdateStoryStatus
{
    use AsAction;

    public function handle(Story $story, string $status): Story
    {
        if ($status !== $story->status->name()) {
            $story->status->transitionTo($status);
        }

        return $story->refresh();
    }
}
