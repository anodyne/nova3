<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\PostType;

class RestorePostType
{
    use AsAction;

    public function handle(PostType $postType): PostType
    {
        if ($postType->trashed()) {
            $postType->restore();

            activity()
                ->performedOn($postType)
                ->event('restored')
                ->log('restored');
        }

        return $postType->refresh();
    }
}
