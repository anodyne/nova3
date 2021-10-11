<?php

declare(strict_types=1);

namespace Nova\PostTypes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\PostTypes\Models\PostType;

class PostTypeDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public PostType $original;

    public PostType $postType;

    public function __construct(PostType $postType, PostType $original)
    {
        $this->original = $original;
        $this->postType = $postType;
    }
}
