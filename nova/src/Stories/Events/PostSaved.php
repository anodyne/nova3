<?php

declare(strict_types=1);

namespace Nova\Stories\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Stories\Models\Post;

class PostSaved
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Post $post) {}
}
