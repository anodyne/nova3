<?php

namespace Database\State;

use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\Story;

class EnsureStoryTimelineIsPresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        Story::create([
            'title' => 'Main Timeline',
            'status' => Completed::class,
        ]);
    }

    private function present(): bool
    {
        return Story::count() > 0;
    }
}
