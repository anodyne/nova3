<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\WordGenerator;
use Nova\PostTypes\Models\PostType;

class DuplicatePostType
{
    use AsAction;

    public function handle(PostType $original): PostType
    {
        $postType = $original->replicate();

        $postType->key = implode('-', (new WordGenerator())->words(2));
        $postType->name = "Copy of {$postType->name}";
        $postType->sort = PostType::count();
        $postType->role_id = $original->role_id;

        $postType->save();

        return $postType->refresh();
    }
}
