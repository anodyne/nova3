<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\Story;

class UpdateStoryStatus
{
    protected $statuses = [
        'completed' => Completed::class,
        'current' => Current::class,
        'upcoming' => Upcoming::class,
    ];

    public function execute(Story $story, string $status): Story
    {
        if ($status !== $story->status->name()) {
            $story->status->transitionTo($this->statuses[$status]);
        }

        return $story->refresh();
    }
}
