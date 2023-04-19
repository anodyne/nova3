<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class ReorderStories
{
    use AsAction;

    public function handle(string $sort): void
    {
        collect(explode(',', $sort))
            ->each(fn ($id, $index) => Story::find($id)->update(['order_column' => $index]));
    }
}
