<?php

namespace Nova\Stories\Models\States;

use Spatie\ModelStates\State;

abstract class StoryStatus extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function displayName(): string
    {
        return ucfirst($this->name());
    }
}
