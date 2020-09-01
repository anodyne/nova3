<?php

namespace Nova\PostTypes\Events;

use Nova\PostTypes\Models\PostType;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PostTypeCreated
{
    use Dispatchable;
    use SerializesModels;

    public $postType;

    public function __construct(PostType $postType)
    {
        $this->postType = $postType;
    }
}
