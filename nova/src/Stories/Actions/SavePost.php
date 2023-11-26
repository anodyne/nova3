<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostData;
use Nova\Stories\Models\Post;

class SavePost
{
    use AsAction;

    public function handle(PostData $data): Post
    {
        return Post::updateOrCreate(
            $data->only('id')->all(),
            $data->except('id')->all()
        );
    }
}
