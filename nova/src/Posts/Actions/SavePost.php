<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Data\PostData;
use Nova\Posts\Models\Post;

class SavePost
{
    use AsAction;

    public function handle(PostData $data): Post
    {
        return Post::updateOrCreate(
            Arr::only($data->all(), 'id'),
            Arr::except($data->all(), 'id')
        );
    }
}
