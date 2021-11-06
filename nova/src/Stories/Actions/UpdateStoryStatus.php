<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Ongoing;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\Story;

class UpdateStoryStatus
{
    use AsAction;

    protected $statuses = [
        'completed' => Completed::class,
        'current' => Current::class,
        'ongoing' => Ongoing::class,
        'upcoming' => Upcoming::class,
    ];

    public function handle(Story $story, string $status): Story
    {
        if ($status !== $story->status->name()) {
            $story->status->transitionTo($status);
            // $story->status->transitionTo($this->statuses[$status]);
        }

        return $story->refresh();
    }
}
