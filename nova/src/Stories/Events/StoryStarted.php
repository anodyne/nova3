<?php

declare(strict_types=1);

namespace Nova\Stories\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Stories\Models\Story;

class StoryStarted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Story $story
    ) {}
}
