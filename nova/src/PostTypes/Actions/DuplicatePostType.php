<?php

namespace Nova\PostTypes\Actions;

use Nova\Foundation\WordGenerator;
use Nova\PostTypes\Models\PostType;

class DuplicatePostType
{
    public function execute(PostType $originalPostType): PostType
    {
        $postType = $originalPostType->replicate();

        $postType->key = implode('-', (new WordGenerator)->words(2));
        $postType->name = "Copy of {$postType->name}";

        $postType->save();

        return $postType->refresh();
    }
}
