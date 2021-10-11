<?php

declare(strict_types=1);

namespace Nova\Stories\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Stories\Models\Story;

class StoryUpdated
{
    use Dispatchable;
    use SerializesModels;

    public Story $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }
}
