<?php

namespace Nova\PostTypes\Events;

use Nova\PostTypes\Models\PostType;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PostTypeDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $originalPostType;

    public $postType;

    public function __construct(PostType $postType, PostType $originalPostType)
    {
        $this->originalPostType = $originalPostType;
        $this->postType = $postType;
    }
}
