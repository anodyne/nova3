<?php

namespace Nova\Stories\Events;

use Nova\Stories\Models\Story;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class StoryCreated
{
    use Dispatchable;
    use SerializesModels;

    public $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }
}
