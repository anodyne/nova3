<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

trait ManageParentStoryStatus
{
    protected function updateParentStoryToOngoing(): void
    {
        $parent = $this->story->parent;

        if ($parent && $parent->status->canTransitionTo(Ongoing::class)) {
            $parent->status->transitionTo(Ongoing::class);
        }
    }

    protected function updateParentStoryToCompletedIfAble(): void
    {
        if ($parent = $this->story->parent) {
            if ($parent->stories()->whereIn('status', ['upcoming', 'ongoing', 'current'])->count() === 0) {
                $parent->status->transitionTo(Completed::class);
            }
        }
    }
}
