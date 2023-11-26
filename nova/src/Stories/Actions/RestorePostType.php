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
                ->causedBy(auth()->user())
                ->performedOn($postType)
                ->log(':subject.name was restored');
        }

        return $postType->refresh();
    }
}
