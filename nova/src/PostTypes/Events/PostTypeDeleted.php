<?php

declare(strict_types=1);

namespace Nova\PostTypes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\PostTypes\Models\PostType;

class PostTypeDeleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public PostType $postType
    ) {
    }
}
