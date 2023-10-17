<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Models\PostType;

class ForceDeletePostType
{
    use AsAction;

    public function handle(PostType $postType): PostType
    {
        return tap($postType)->forceDelete();
    }
}
