<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class PublishPage
{
    use AsAction;

    public function handle(Page $page): Page
    {
        $page->published_blocks = $page->blocks;
        $page->published_at = now();
        $page->save();

        return $page->refresh();
    }
}
