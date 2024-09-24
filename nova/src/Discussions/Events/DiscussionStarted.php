<?php

declare(strict_types=1);

namespace Nova\Discussions\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Discussions\Models\Discussion;

class DiscussionStarted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Discussion $discussion
    ) {}
}
