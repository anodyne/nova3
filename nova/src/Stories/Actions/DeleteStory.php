<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class DeleteStory
{
    use AsAction;

    public function handle(Story $story): Story
    {
        return tap($story)->delete();
    }
}
