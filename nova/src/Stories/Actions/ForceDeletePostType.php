<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\PostType;

class ForceDeletePostType
{
    use AsAction;

    public function handle(PostType $postType): PostType
    {
        return tap($postType)->forceDelete();
    }
}
