<?php

declare(strict_types=1);

namespace Nova\Posts\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Posts\Models\Post;

class PostDeleted
{
    use Dispatchable;
    use SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
