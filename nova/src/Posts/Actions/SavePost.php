<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Data\PostData;
use Nova\Posts\Models\Post;

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
