<?php

declare(strict_types=1);

namespace Nova\PostTypes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\PostTypes\Models\PostType;

class PostTypeCreated
{
    use Dispatchable;
    use SerializesModels;

    public PostType $postType;

    public function __construct(PostType $postType)
    {
        $this->postType = $postType;
    }
}
