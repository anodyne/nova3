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
        $replica = $original->replicate();

        $replica->key = implode('-', (new WordGenerator())->words(2));
        $replica->name = "Copy of {$original->name}";
        $replica->role_id = $original->role_id;

        $replica->save();

        return $replica->refresh();
    }
}
