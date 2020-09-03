<?php

namespace Nova\Stories\Actions;

use Nova\Stories\Models\Story;

class ReorderStories
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($roleId, $index) {
            Story::where('id', $roleId)->update(['sort' => $index]);
        });
    }
}
