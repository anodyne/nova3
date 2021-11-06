<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class StoryStatus extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function displayName(): string
    {
        return ucfirst($this->name());
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Upcoming::class)
            ->allowTransitions([
                [Upcoming::class, Completed::class, UpcomingToCompleted::class],
                [Upcoming::class, Current::class, UpcomingToCurrent::class],
                [Upcoming::class, Ongoing::class, UpcomingToOngoing::class],

                [Current::class, Completed::class, CurrentToCompleted::class],
                [Current::class, Ongoing::class, CurrentToOngoing::class],
                [Current::class, Upcoming::class, CurrentToUpcoming::class],

                [Ongoing::class, Completed::class, OngoingToCompleted::class],
                [Ongoing::class, Current::class, OngoingToCurrent::class],
                [Ongoing::class, Upcoming::class, OngoingToUpcoming::class],

                [Completed::class, Current::class, CompletedToCurrent::class],
                [Completed::class, Ongoing::class, CompletedToOngoing::class],
                [Completed::class, Upcoming::class, CompletedToUpcoming::class],
            ]);
    }
}
